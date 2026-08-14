// resources/assets/js/wall/entry-actions.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { withRouter, Link } from 'react-router-dom';
import { decorators } from '@orange-marmalade/paginate-this';
import { actionCreators, LIST_ID as listIdWall } from '../../stores/wall';
import { formatMessage } from '../../init-app';
import { typeContent } from '../../helpers/redux-utils';
import { getModule } from '../../helpers/states';
import Misc from '../../helpers/misc';
import laroute from '../../helpers/laroute';
import $ from 'jquery';

// app components
import ConfirmWindow from '../confirm-window';

class EntryActions extends Component {
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
        const { deleteEntry, itemId } = this.props;

        deleteEntry(itemId);
    }

    confirmClosed() {
        this.setState({ confirmingDelete: false });
    }

    render() {
        const { record, removing, updating, itemId, listId, deleteEntry, match, history, location, staticContext, ...props } = this.props;

        const currentChannel = (location.state && location.state.channel) || 'general';

        return (
            <ul
                data-dropdown-content
                className="opts-action-dropdown radius no-arrow text-sm"
                aria-hidden="true"
                ref={node => { this.nodeDrop = node; }}
                {...props}
            >
                { typeContent(record.codigoModulo) &&
                    [getModule('wall'), getModule('forum'), getModule('calendar')].indexOf(record.codigoModulo) !== -1 &&
                    !record.isAuthorizedToDelete && (<li>
                        <Link
                            className="text-left"
                            to={{
                                pathname: `${match.url}/${currentChannel}/edit/${typeContent(record.codigoModulo)}`,
                                state: {
                                    modal: true,
                                    edit: true,
                                    itemId,
                                    listId
                                }
                            }}
                        >
                            <ul className="inline-list-grid align-center">
                                <li>{formatMessage('community/entry_actions/edit_entry')}</li>
                                <li className="short-col">
                                    <i className="mdi mdi-pencil mdi-21 vcenter"></i>
                                </li>
                            </ul>
                        </Link>
                    </li>)
                }
                { typeContent(record.codigoModulo) &&
                    [getModule('blog')].indexOf(record.codigoModulo) !== -1 &&
                    (<li>
                        <a className="text-left" href={Misc.urlFull(laroute.route('blog.categoria.articulo', {
                            category: record.urlTipoContenido,
                            article: record.urlContenidoMuro
                        }))}>
                            <ul className="inline-list-grid align-center">
                                <li>{formatMessage('community/entry_actions/edit_entry')}</li>
                                <li className="short-col">
                                    <i className="mdi mdi-pencil mdi-21 vcenter"></i>
                                </li>
                            </ul>
                        </a>
                    </li>)
                }
                <li>
                    <a href="#" className="text-left" onClick={this.handleDelete}>
                        <ul className="inline-list-grid align-center">
                            <li>{formatMessage('community/entry_actions/delete_entry')}</li>
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
                            title={formatMessage('community/confirm_delete_title')}
                            render={() => <span>{formatMessage('community/confirm_delete_message')}</span>}
                        />
                    }
                </li>
            </ul>
        )
    }
}

EntryActions.propTypes = {
    id: PropTypes.string.isRequired,
    listId: PropTypes.string.isRequired,
    itemId: PropTypes.oneOfType([
        PropTypes.number,
        PropTypes.string
    ]).isRequired,
    deleteEntry: PropTypes.func.isRequired,
    removing: PropTypes.bool,
    updating: PropTypes.bool,
    record: PropTypes.shape({
        codigoModulo: PropTypes.number
    }),
    match: PropTypes.shape({
        url: PropTypes.string
    }).isRequired
};

EntryActions.defaultProps = {
    removing: false,
    updating: false
};

const mapDispatchToProps = dispatch => bindActionCreators({ deleteEntry: actionCreators.deleteEntry }, dispatch);

export default withRouter(connect(null, mapDispatchToProps)(decorators.withRecordProps(EntryActions)))
