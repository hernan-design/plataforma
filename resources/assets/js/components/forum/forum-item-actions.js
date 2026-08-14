// resources/assets/js/components/forum/forum-item-actions.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { withRouter, Link } from 'react-router-dom';
import { decorators } from '@orange-marmalade/paginate-this';
import { actionCreators } from '../../stores/forum';
import { formatMessage } from '../../init-app';
import { typeContent } from '../../helpers/redux-utils';
import { getModule } from '../../helpers/states';
import Misc from '../../helpers/misc';
import laroute from '../../helpers/laroute';
import $ from 'jquery';

// app components
import ConfirmWindow from '../confirm-window';

class ForumItemActions extends Component {
    constructor(props) {
        super(props);

        // initial state
        this.state = {
            confirmingDelete: false
        };

        // bind event handlers
        this.handleDelete = this.handleDelete.bind(this);
        this.confirmDelete = this.confirmDelete.bind(this);
        this.confirmClosed = this.confirmClosed.bind(this);
    }

    componentDidMount() {
        if( ({}).hasOwnProperty.call($.fn, 'foundation') ) {
            $(document).foundation('dropdown', 'reflow');
        }
    }

    componentWillUnmount() {
        if( ({}).hasOwnProperty.call($.fn, 'foundation') ) {
            $(this.nodeDrop).find('[data-dropdown]').foundation('dropdown', 'off');
        }
    }

    handleDelete(e) {
        e.preventDefault();

        this.setState({ confirmingDelete: true });
    }

    confirmDelete() {
        const { deleteForum, itemId, listId, record } = this.props;

        deleteForum({ itemId, listId, foro: record.codigoForo });
    }

    confirmClosed() {
        this.setState({ confirmingDelete: false });
    }

    render() {
        const { className, ownerData, record, removing, updating, itemId, listId, deleteForum, match, history, location, hidden, autoclose, staticContext, dropOptions, ...props } = this.props;

        const options = {
            is_hover: false,
            ...dropOptions
        };
        const _dropOptions = JSON.stringify(options).replace(
            /([{}"])|(,)/g,
            (str, p1) => (typeof p1 !== 'undefined' ? '': ';')
        );

        if(!Object.keys(ownerData).length || ownerData.nicknameUsuario !== record.nicknameUsuario) {
            return null;
        }

        return (
            <div>
                <a className={["action-hover-circle icon-21", className].join(' ')} data-dropdown={props.id} aria-controls={props.id} aria-expanded={false} data-options={_dropOptions} style={styles.actionActions}>
                    <i className="mdi mdi-dots-vertical"></i>
                </a>
                <ul
                    data-dropdown-content
                    className="opts-action-dropdown radius no-arrow text-sm"
                    aria-hidden={hidden}
                    aria-autoclose={autoclose}
                    ref={node => { this.nodeDrop = node; }}
                    {...props}
                >
                    <li>
                        <Link
                            className="text-left"
                            to={{
                                pathname: `${location.pathname}`,
                                state: {
                                    modal: true,
                                    edit: true,
                                    itemId,
                                    listId
                                }
                            }}
                        >
                            <ul className="inline-list-grid align-center">
                                <li>{formatMessage('forum/theme_actions/edit')}</li>
                                <li className="short-col">
                                    <i className="mdi mdi-pencil mdi-21 vcenter"></i>
                                </li>
                            </ul>
                        </Link>
                    </li>
                    <li>
                        <a href="#" className="text-left" onClick={this.handleDelete}>
                            <ul className="inline-list-grid align-center">
                                <li>{formatMessage('forum/theme_actions/delete')}</li>
                                <li className="short-col">
                                    <i className="mdi mdi-delete-forever mdi-21 vcenter"></i>
                                </li>
                            </ul>
                        </a>
                        { this.state.confirmingDelete &&
                            <ConfirmWindow
                                onConfirm={this.confirmDelete}
                                onClosed={this.confirmClosed}
                                className="xtiny"
                                title={formatMessage('forum/confirm_delete_title')}
                                render={() => <span>{formatMessage('forum/confirm_delete_message')}</span>}
                            />
                        }
                    </li>
                </ul>
            </div>
        )
    }
}

ForumItemActions.propTypes = {
    id: PropTypes.string.isRequired,
    hidden: PropTypes.bool,
    autoclose: PropTypes.bool,
    dropOptions: PropTypes.object,
    listId: PropTypes.string.isRequired,
    itemId: PropTypes.oneOfType([
        PropTypes.number,
        PropTypes.string
    ]).isRequired,
    deleteForum: PropTypes.func.isRequired,
    removing: PropTypes.bool,
    updating: PropTypes.bool,
    record: PropTypes.shape({
        codigoUsuario: PropTypes.number,
        codigoForo: PropTypes.oneOfType([
            PropTypes.number,
            PropTypes.string
        ])
    }).isRequired,
    match: PropTypes.shape({
        url: PropTypes.string
    }).isRequired
};

ForumItemActions.defaultProps = {
    className: '',
    removing: false,
    updating: false,
    hidden: true,
    autoclose: true,
    ownerData: {},
    dropOptions: {}
};

const styles = {
    'actionActions': {
        position: 'absolute',
        top: '15px',
        right: '20px'
    }
};

const mapStateToProps = state => ({
    ownerData: state.session.user
});

const mapDispatchToProps = (dispatch, ownProps) => bindActionCreators({
    deleteForum: actionCreators.deleteForumOfList
}, dispatch);

export default withRouter(connect(mapStateToProps, mapDispatchToProps)(decorators.withRecordProps(ForumItemActions)))
