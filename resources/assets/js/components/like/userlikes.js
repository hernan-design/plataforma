// resources/assets/js/components/like/userlikes.js
import React from 'react';
import PropTypes from 'prop-types';
import Misc from '../../helpers/misc';
import { thumbs } from '../../helpers/states';
import laroute from '../../helpers/laroute';
import { decorators } from '@orange-marmalade/paginate-this';

const UserLikes = ({ record }) => (
    <li>
        <ul className="inline-list-grid no-spacing lighter-text no-bullet">
            <li className="has-image">
                <a href={ Misc.urlFull(laroute.route('usuario.nickname', {nickname: record.nicknameUsuario})) } title={record.nombreUsuario} className="rounded-thumb no-outline">
                    <img src={record.imagenUsuario} alt={record.nombreUsuario} className="rounded-img size35" onError={e => { Misc.imageDefault(e.target, thumbs.avatar()) }}/>
                </a>
            </li>
            <li>
                <ul className="no-bullet text-md">
                    <li>
                        <a href={ Misc.urlFull(laroute.route('usuario.nickname', {nickname: record.nicknameUsuario})) } title={record.nombreUsuario} className="dark-text">
                            {record.nombreUsuario}
                        </a>
                    </li>
                    <li>
                        <a href={ Misc.urlFull(laroute.route('usuario.nickname', {nickname: record.nicknameUsuario})) } title={record.nombreUsuario} className="gray-base-text text-xmd">
                            <em>{Misc.strToNickname(record.nicknameUsuario)}</em>
                        </a>
                    </li>
                </ul>

            </li>
        </ul>
    </li>
);

UserLikes.propTypes = {
    listId: PropTypes.string.isRequired,
    record: PropTypes.object.isRequired,
    updating: PropTypes.bool,
    removing: PropTypes.bool
};

UserLikes.defaultProps = {
    listId: '',
    record: {},
    updating: false,
    removing: false
}

export default decorators.withRecordProps(UserLikes)
