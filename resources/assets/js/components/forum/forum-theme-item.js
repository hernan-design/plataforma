// resources/assets/js/components/forum/forum-theme-item.js
import React from 'react';
import { decorators } from '@orange-marmalade/paginate-this';
import Misc, { strToNickname, imageDefault } from '../../helpers/misc';
import { Link } from 'react-router-dom';
import { thumbs } from '../../helpers/states';
import { formatMessage } from '../../init-app';
import laroute from '../../helpers/laroute';
import moment from 'moment';

// app components
import ForumItemActions from './forum-item-actions';
import SpinnerLoader from '../spinner-loader';

const ForumThemeItem = ({ record, listId, itemId, removing, updating }) => (
    <li className="separator">
        <div className="card-forum-info card-data-info">
            <ul className="inline-list-grid align-top no-spacing">
                <li className="has-image">
                    <a href={ Misc.urlFull(laroute.route('usuario.nickname', { nickname: record.nicknameUsuario })) } className="rounded-thumb no-outline" title={record.nombreUsuario}>
                        <img src={record.imagenUsuario} alt={strToNickname(record.nicknameUsuario)} className="size35" onError={e => { imageDefault(e.target, thumbs.avatar()) }} />
                    </a>
                </li>
                <li>
                    <h5><Link to={laroute.route('foro.categoria.tema', { category: record.urlCategoriaForo, theme: record.urlForo })} className="dark-text">{record.tituloForo}</Link></h5>

                    <div className="text-sm gray-base-text">
                        <a href={ Misc.urlFull(laroute.route('usuario.nickname', { nickname: record.nicknameUsuario })) } title={record.nombreUsuario} className="dark-text">{strToNickname(record.nicknameUsuario)}</a>
                        <span className="vertical-separator">&middot;</span>
                        {record.nombreCategoriaForo}
                        <span className="vertical-separator">&middot;</span>
                        { moment(`${record.fechaAperturaForo} ${record.horaAperturaForo}`).fromNow() }
                        <span className="vertical-separator">&middot;</span>
                        <span>
                            <i className="mdi mdi-thumb-up-outline mdi-16 gutter-right vcenter"></i>
                            <span>{record.contadorLike}</span>
                        </span>
                        <span className="vertical-separator">&middot;</span>
                        <span>
                            <i className="mdi mdi-comment-outline mdi-16 gutter-right vcenter"></i>
                            <span>{record.contadorComentario}</span>
                        </span>
                    </div>
                </li>
            </ul>
            <ForumItemActions id={`drop-theme-actions-${record.cod}`} listId={listId} itemId={itemId} />
            { removing && <SpinnerLoader text={formatMessage('deleting_text')} /> }
            { updating && <SpinnerLoader text={formatMessage('updating_text')} /> }
        </div>
    </li>
);

ForumThemeItem.defaultProps = {
    updating: false,
    removing: false
};

export default decorators.withRecordProps(ForumThemeItem)
