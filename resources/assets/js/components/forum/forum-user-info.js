// resources/assets/js/components/forum/forum-user-info.js
import React from 'react';
import Misc from '../../helpers/misc';
import { thumbs } from '../../helpers/states';
import laroute from '../../helpers/laroute.js';
import moment from 'moment';

const ForumUserInfo = (props) => (
    <ul className="forum-theme-user-info inline-list-grid align-top no-spacing">
        <li className="short-col">
            <a href={Misc.urlFull(laroute.route('usuario.nickname', {nickname: props.nicknameUsuario}))} className="rounded-thumb no-outline" title={Misc.strToNickname(props.nicknameUsuario)}>
                <img src={props.imagenUsuario} alt={Misc.strToNickname(props.nicknameUsuario)} className="rounded-img size40" onError={e => { Misc.imageDefault(e.target, thumbs.avatar()) }} />
            </a>
        </li>
        <li>
            <ul className="no-bullet">
                <li><a href={Misc.urlFull(laroute.route('usuario.nickname', {nickname: props.nicknameUsuario}))}>{props.nombreUsuario}</a></li>
                <li>
                    <span className="linear-span text-md gray-base-text normal-text">
                        {props.nombreCategoriaForo}
                        <span>&nbsp;&middot;&nbsp;</span>
                        {props.timeAgo}
                    </span>
                </li>
            </ul>
        </li>
    </ul>
);

export default ForumUserInfo
