// resources/assets/js/components/active-account.js
import React from 'react';
import PropTypes from 'prop-types';
import laroute from '../../helpers/laroute';
import { formatMessage } from '../../init-app';

const ActiveAccount = ({ text }, { store }) => {
    const { session } = store.getState();

    if(session.user.usuarioVerificado) {
        return null;
    }

    return(
        <div className="panel-content radius-tablet-up">
            <p>{text}</p>
            <a href={`${session.rootUrl}${laroute.route('verify.account')}`} className="button small sky-blye radius btn-lowerc bold-text">{ formatMessage('community/verify_account/label_action') }</a>
        </div>
    );
}

ActiveAccount.contextTypes = {
    store: PropTypes.object.isRequired
}

ActiveAccount.defaultProps = {
    text: formatMessage('community/verify_account/description')
}

export default ActiveAccount
