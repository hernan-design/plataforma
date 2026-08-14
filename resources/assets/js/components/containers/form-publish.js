// resources/assets/js/components/containers/form-publish.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import { getItem, isUpdating } from '@orange-marmalade/paginate-this';
import $ from 'jquery';
import {
    select2Trigger,
    datepickerTrigger,
    initConfigForm,
    formatMessage
} from '../../init-app';

// app components
import Form from './form';
import TopFormPublish from '../top-form-publish';
import SpinnerLoader from '../spinner-loader';

class FormPublish extends Component {
    constructor(props, context) {
        super(props, context);

        // initial state
        this.state = {
            edit: !!(props.location.state && props.location.state.edit),
            record: null
        };

        // initial attributes
        this.store = context.store;

        // bind event handlers
        this.handleClose = this.handleClose.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.availableChannel = this.availableChannel.bind(this);

        // call validate editing
        this.validateEditing(props.location);
    }

    componentDidMount() {
        this.assignPlugins();
    }

    componentWillUnmount() {
        this.unassignPlugins();
    }

    componentWillReceiveProps(nextProps) {
        if( this.props.location !== nextProps.location ) {
            this.validateEditing(nextProps.location);
        }
    }

    componentDidUpdate() {
        this.assignPlugins();
    }

    handleClose(e) {
        e.preventDefault();
        e.stopPropagation();

        this.props.onClose && this.props.onClose();
    }

    handleChange(e) {
        this.props.onChange && this.props.onChange(e);
    }

    handleSubmit(e) {
        e.preventDefault();

        const response = Promise.resolve(
            this.props.onSubmit &&
            this.props.onSubmit(e,
                this.state.edit,
                this.state.record
            )
        );

        response.then(resp => {
            if( !(resp instanceof Error) ) {
                this.props.onClose && this.props.onClose();
            }
        });
    }

    // assign plugins to elements
    assignPlugins() {
        const $nodeForm = $(this.nodeForm);

        initConfigForm($nodeForm);

        $nodeForm.find('select').each((index, el) => {
            select2Trigger(el);
        });

        $nodeForm.find('.datetimeafterpk').each((index, el) => {
            datepickerTrigger(el);
        });
    }

    // unassign plugins
    unassignPlugins() {
        const $nodeForm = $(this.nodeForm);

        $nodeForm.find('select').each((index, el) => {
            if( typeof $(el).data('select2') !== 'undefined' ) {
                $(el).select2('destroy');
                $(el).off('select2');
            }

            $(el).material_select('destroy');
        });

        $nodeForm.find('.datetimeafterpk').each((index, el) => {
            if( typeof $(el).data('xdsoft_datetimepicker') !== 'undefined' ) {
                $(el).datetimepicker('destroy');
            }
        });
    }

    availableChannel(channel) {
        const { ownerData, channels } = this.props;

        const evalChannel = ch => (ch.codigoCanal === channel.codigoCanal && ch.canalAbierto);

        return !!(
            channels.findIndex(evalChannel) !== -1 ||
            ownerData.channels.indexOf(channel.codigoCanal) !== -1
        );
    }

    validateEditing(location) {
        if(
            location.state &&
            location.state.edit &&
            location.state.itemId &&
            location.state.listId
        ) {
            const record = getItem(
                this.store.getState(),
                location.state.listId,
                location.state.itemId
            ).toJS();
            let passRecord = Promise.resolve({});

            if( typeof this.props.loadRecord === 'function' ) {
                passRecord = this.props.loadRecord(record);
            }

            passRecord.then(data => {
                this.setState({
                    edit: location.state.edit,
                    record: {...record, ...data}
                })
            });
        }
    }

    render() {
        const { children, component:Component, render, id, className, style, formRef, onChange, onSubmit, type, isAdding, isEditing, loadRecord, ...props } = this.props;

        const passProps = {
            ...props,
            availableChannel: this.availableChannel,
            edit: this.state.edit,
            record: this.state.record
        };

        const shouldRenderFields = !this.state.edit || !!(this.state.edit && this.state.record);

        return(
            <Form
                id={id}
                onSubmit={this.handleSubmit}
                onChange={this.handleChange}
                style={style}
                className={className}
                formRef={node => {
                    this.nodeForm = node;
                    formRef && formRef(node);
                }}
            >
                <div className="card-form" style={{ marginTop: 0 }}>
                    <div className="card-content">
                        <TopFormPublish handleClose={this.handleClose} type={type} />
                        { shouldRenderFields ? (Component ?
                            <Component {...passProps} />
                            :
                            ( render ?
                                render(passProps)
                                :
                                children
                            ))
                            :
                            <SpinnerLoader />
                        }
                    </div>

                    <div className="card-action">
                        <ul className="inline-list-grid align-center text-right text-md no-spacing">
                            <li>
                                <a href="#" className="dark-text normal-text" onClick={this.handleClose}>{formatMessage('community/publish_cancel_button')}</a>
                            </li>
                            <li className="short-col">
                                <button type="submit" className={`waves-effect waves-light button small sky-blue radius btn-bold btn-clean-margin ${isAdding ? 'disabled' : ''}`}>
                                    { !this.state.edit ?
                                        formatMessage('community/publish_create_button')
                                        :
                                        formatMessage('community/publish_edit_button')
                                    }
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                { (isAdding || isEditing) && <SpinnerLoader /> }
            </Form>
        );
    }
}

FormPublish.propTypes = {
    id: PropTypes.string.isRequired,
    onChange: PropTypes.func,
    onSubmit: PropTypes.func,
    className: PropTypes.string,
    children: PropTypes.element,
    component: PropTypes.element,
    render: PropTypes.func,
    formRef: PropTypes.func,
    ownerData: PropTypes.object.isRequired,
    history: PropTypes.object.isRequired,
    location: PropTypes.object.isRequired,
    channels: PropTypes.arrayOf(PropTypes.object),
    onClose: PropTypes.func,
    type: PropTypes.string,
    isAdding: PropTypes.bool,
    isEditing: PropTypes.bool,
    loadRecord: PropTypes.func
};

FormPublish.defaultProps = {
    className: '',
    style: {},
    channels: [],
    type: '',
    isAdding: false,
    isEditing: false
};

FormPublish.contextTypes = {
    store: PropTypes.object.isRequired
};

const mapStateToProps = (state, ownProps) => ({
    ownerData: state.session.user,
    channels: state.channel.channels,
    // isAdding: state.recipeEntries.get('isAdding'),
    isEditing: (ownProps.location.state &&
        ownProps.location.state.itemId &&
        ownProps.location.state.listId) ?
        isUpdating(state, ownProps.location.state.listId, ownProps.location.state.itemId) : false
});

export default withRouter(connect(mapStateToProps)(FormPublish))
