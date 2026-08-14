// resources/assets/js/components/forum/static/related-topic.js
import React from 'react';
import PropTypes from 'prop-types';
import { decorators } from '@orange-marmalade/paginate-this';
import laroute from '../../../helpers/laroute';
import Misc, { strToNickname, imageDefault } from '../../../helpers/misc';
import { thumbs } from '../../../helpers/states';
import { Link } from 'react-router-dom';

const RelatedTopic = ({ record }) => (
    <li className="separator">
        <Link
            to={laroute.route('foro.categoria.tema', {
                category: record.urlCategoriaForo,
                theme: record.urlForo
            })}
            className="card-forum-info card-data-info"
        >
            <ul className="inline-list-grid align-top no-spacing">
                <li className="has-image">
                    <span className="rounded-thumb no-outline" title={record.nombreUsuario}><img src={record.imagenUsuario} className="rounded-img size35" onError={e => { imageDefault(e.target, thumbs.avatar()) }} /></span>
                </li>
                <li>
                    <h6 className="clean-header text-xmd dark-text">{record.tituloForo}</h6>
                    <span className="text-sm gray-base-text">
                        <span title={record.nombreUsuario} className="dark-text">{strToNickname(record.nicknameUsuario)}</span>
                        &nbsp;
                        {record.timeAgo}
                        <span className="vertical-separator">&middot;</span>
                        <span>
                            <i className="mdi mdi-thumb-up-outline mdi-14 gutter-right vcenter"></i>
                            <span>{record.contadorLike}</span>
                        </span>
                        <span className="vertical-separator">&middot;</span>
                        <span>
                            <i className="mdi mdi-comment-outline mdi-14 gutter-right vcenter"></i>
                            <span>{record.contadorComentario}</span>
                        </span>
                    </span>
                </li>
            </ul>
        </Link>
    </li>
);

RelatedTopic.propTypes = {
    listId: PropTypes.string.isRequired,
    record: PropTypes.object.isRequired
};

export default decorators.withRecordProps(RelatedTopic);
