// resources/assets/js/components/forum/button-publish-forum.js
import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { strToNickname, imageDefault } from '../../helpers/misc';
import { thumbs } from '../../helpers/states';
import { formatMessage } from '../../init-app';
import { Link } from 'react-router-dom';

const ButtonPublishForum = ({ match, ownerData }) => (
    Object.keys(ownerData).length && ownerData.usuarioVerificado ? (
        <div id="panel-forum-publishing" className="panel-content radius-tablet-up">
            <ul className="inline-list-grid vcenter">
                <li className="has-image">
                    <img src={ownerData.imagenUsuario} alt={strToNickname(ownerData.nicknameUsuario)} onError={e => { imageDefault(e.target, thumbs.avatar()) }} className="rounded-img size35" />
                </li>
                <li>
                    <span className="gray-base-text text-md normal-text">{formatMessage('forum/publish_button_msg')}</span>
                </li>
                <li>
                    <Link to={{
                        pathname: `${match.url}`,
                        state: {
                            modal: true,
                            publish: true
                        }
                    }}
                    className="button xsmall sky-blue radius btn-resetc btn-bold btn-clean-margin waves-effect waves-light"
                    >Crear un tema</Link>
                </li>
            </ul>
        </div>
    ) : null
);

ButtonPublishForum.propTypes = {
    match: PropTypes.object.isRequired,
    ownerData: PropTypes.object.isRequired
};

ButtonPublishForum.defaultProps = {
    ownerData: {}
};

const mapStateToProps = state => ({
    ownerData: state.session.user
});

export default connect(mapStateToProps)(ButtonPublishForum)
