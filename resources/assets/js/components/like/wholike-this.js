// resources/assets/js/components/like/wholike-this.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { composables, getLike } from '../../stores/like';
import Misc from '../../helpers/misc';
import { formatMessage } from '../../init-app';
import $ from 'jquery';

// app components
import BaseModal from '../containers/base-modal';
import UserLikesList from './userlikes-list';

const createMarkup = (markup) => {
  return {__html: markup};
}

class WhoLikeThis extends Component {
    constructor(props) {
        super(props);

        // inital state
        this.state = {
            showUserLikes: false
        };

        // bind event handlers
        this.handleLikeUsers = this.handleLikeUsers.bind(this);
        this.handleClose = this.handleClose.bind(this);
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
        this.handleClose();
    }

    handleLikeUsers(e) {
        e.preventDefault();

        if(e.target.localName === 'a') {
            this.setState({ showUserLikes: true });
        }
    }

    handleClose() {
        this.setState({ showUserLikes: false });
    }

    render() {
        const { srcparams, counterLikes, authLike, listId, ...props } = this.props;
        const slugInstitution = process.env.SLUG_INSTITUTION;

        var messageIncludingMe = 'like/likeIncludingMe';
        var messageExcludingMe  = 'like/likeExcludingMe';

        if (slugInstitution == 'propace') {
            messageIncludingMe = 'like/likeIncludingMePropace';
            messageExcludingMe  = 'like/likeExcludingMePropace';
        }

        return(
            <ul
                className="post-social-shared clearfix md-dropdown drop-strip radius"
                data-dropdown-content
                ref={node => { this.nodeDrop = node; }}
                {...props}
            >
                <li>
                    <span onClick={this.handleLikeUsers} className="lighter-text light-text" dangerouslySetInnerHTML={createMarkup(
                        authLike ?
                        formatMessage(messageIncludingMe, counterLikes)
                        :
                        formatMessage(messageExcludingMe, counterLikes)
                    )}>
                    </span>
                    { this.state.showUserLikes &&
                        (<BaseModal
                            id={`modal-base-material-${props.id}`}
                            className="modal-base-material tiny"
                            onClosed={this.handleClose}
                            title={formatMessage('like/whoLikeThis_title')}
                            noScroll
                        >
                            <UserLikesList listId={listId} />
                        </BaseModal>)
                    }
                </li>
            </ul>
        );
    }
}

WhoLikeThis.propTypes = {
    id: PropTypes.string.isRequired,
    listId: PropTypes.string.isRequired,
    srcparams: PropTypes.string.isRequired,
    authLike: PropTypes.bool,
    counterLikes: PropTypes.number
};

WhoLikeThis.defaultProps = {
    authLike: false,
    counterLikes: 0
};

export default WhoLikeThis
