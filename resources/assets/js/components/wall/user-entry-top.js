// resources/assets/js/components/wall/user-entry-top.js
import React from 'react';
import PropTypes from 'prop-types';
import Misc from '../../helpers/misc';
import { thumbs, getModule } from '../../helpers/states';

// app components
import AccountDropdown from '../account-dropdown';

const UserEntryTop = (props) => {
    let iconType = '';

    switch(props.codigoModulo) {
        case getModule('calendar'): iconType = 'mdi-calendar';
            break;
        case getModule('forum'): iconType = 'mdi-forum';
            break;
        case getModule('blog'): iconType = 'mdi-pen';
            break;
        case getModule('learn'): iconType = 'mdi-school';
            break;
        default:
            iconType = 'mdi-pin';
    }

    return(
        <ul className="card-user-entry inline-list-grid align-center no-spacing">
            <li className="has-image">
                <a data-dropdown={`drop-account-info-${props.cod}`} aria-expanded={false} data-options="is_hover:true" className="rounded-thumb no-outline" title={props.nombreUsuario}>
                    <img src={props.imagenUsuario} alt={props.nombreUsuario} className="rounded-img size30" onError={e => { Misc.imageDefault(e.target, thumbs.avatar()) }} />
                </a>
                <AccountDropdown id={`drop-account-info-${props.cod}`} {...props} />
            </li>
            <li>
                <a href={Misc.urlFull(props.urlProfile)} className="bold-text">{Misc.strToNickname(props.nicknameUsuario)}</a>
                <span className="vertical-separator">&middot;</span>
                <span className="light-text text-md">{props.timeAgo}</span>
                <span className="vertical-separator">&middot;</span>
                <i className={`mdi ${iconType} mdi-12 gray-base-text`}></i>
            </li>
        </ul>
    );
};

UserEntryTop.propTypes = {
    cod: PropTypes.oneOfType([
        PropTypes.number,
        PropTypes.string
    ]).isRequired,
    nombreUsuario: PropTypes.string.isRequired,
    imagenUsuario: PropTypes.string.isRequired,
    urlProfile: PropTypes.string.isRequired,
    nicknameUsuario: PropTypes.string.isRequired,
    timeAgo: PropTypes.string
};

UserEntryTop.defaultProps = {
    cod: '',
    nombreUsuario: '',
    imagenUsuario: '',
    urlProfile: '',
    nicknameUsuario: '',
    timeAgo: ''
};

export default UserEntryTop
