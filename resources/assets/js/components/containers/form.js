import React, { Component } from 'react';
import PropTypes from 'prop-types';
import $ from 'jquery';
import Misc from '../../helpers/misc';
import { actionCreators } from '../../stores/form';

const Foundation = typeof window !== 'undefined' ? window.Foundation : null;

class Form extends Component {

    constructor (props, context) {
        super(props, context);

        // initialize states
        this.state = {};

        // binding event handlers
        this._handleSubmit = this._handleSubmit.bind(this);
        this._handleChange = this._handleChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        Form.resetFields = this.resetFields.bind(this);
    }

    getChildContext () {
        return {
            _fields: this.state,
            creatorForm: this.formEl
        }
    }

    componentDidMount () {
        this.$formEl = $(this.formEl);
        this.$formEl.foundation('abide', 'reflow');
        this.$formEl.on('submit', this.handleSubmit);

        let formData = Misc.formToJson(this.formEl);
        if(formData) {
            this.updateState(formData);
        }
    }

    componentWillUnmount () {
        this.$formEl.off('submit', this.handleSubmit);
        this.updateState({});
    }

    _handleChange (evt) {
        if(evt.target.name) {
            this.updateState({ [evt.target.name]: evt.target.value });
        }

        this.props.onChange && this.props.onChange(evt);
    }

    _handleSubmit (evt) {
        if(!this.props.onSubmit) return null;

        evt.preventDefault();
    }

    updateState (fields) {
        const { store } = this.context;

        this.setState({...fields}, () => {
            if(this.formEl.id) {
                store.dispatch(actionCreators.fillFormData({
                    [this.formEl.id]: this.state
                }));
            }
        });
    }

    formRef (node) {
        this.formEl = node;

        // calls parent prop function and pass a form reference
        this.props.formRef && this.props.formRef(node);
    }

    handleSubmit (evt) {
        if(typeof this.$formEl.attr('data-invalid') !== 'undefined') { return false; }

        let formData = Misc.formToJson(this.formEl);

        if(formData) {
            this.updateState(formData);
        }

        this.props.onSubmit && this.props.onSubmit(evt, formData);
    }

    resetFields() {
        const $formEl = $(this.formEl);
        const { store } = this.context;

        if(this.formEl) {
            $(document).foundation('abide', 'reset', $formEl);

            let $resetedInputs = $(':input', this.formEl).not(':button, :submit, :reset, :hidden, :checkbox, :radio, .select-dropdown').val('');

            if(Foundation && $resetedInputs.length) {
                $resetedInputs.removeAttr(Foundation.libs.abide.invalid_attr);
            }

            // reset selects
            this.formEl.reset();
            $formEl.find('select').val('').trigger('change.select2');

            // if(this.formEl.id) {
            //     store.dispatch(actionCreators.fillFormData({
            //         [this.formEl.id]: this.state
            //     }));
            // }
        }
    }

    render () {
        const { id, children, onSubmit, onChange, formRef, staticContext, ...rest } = this.props;

        return (
            <form
                id={id}
                onSubmit={this._handleSubmit}
                onChange={this._handleChange}
                data-abide={true}
                ref={node => { this.formRef(node); }}
                {...rest}
            >
                {children}
            </form>
        );
    }
}

Form.contextTypes = {
    store: PropTypes.object.isRequired
};

Form.childContextTypes = {
    _fields: PropTypes.object,
    creatorForm: PropTypes.any
};

Form.propTypes = {
    id: PropTypes.string.isRequired,
    onSubmit: PropTypes.func,
    onChange: PropTypes.func,
    formRef: PropTypes.func
};

Form.defaultProps = {
    id: '',
    noValidate: 'novalidate'
};

export default Form
