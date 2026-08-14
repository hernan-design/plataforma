// resources/assets/js/components/confirm-window.js
import React from 'react';
import PropTypes from 'prop-types';
import $ from 'jquery';
import { formatMessage } from '../init-app';

// app components
import BaseModal from './containers/base-modal';

const ConfirmWindow = ({ className, onConfirm, ...props }) => {
    let modal = null;

    const handleConfirm = (e) => {
        e.preventDefault();

        if(modal) { $(modal.nodeModal).foundation('reveal', 'close'); }

        onConfirm && onConfirm();
    }

    return(
        <BaseModal
            className={`reveal-modal-main dialog-confirm clearfix ${className}`}
            iconClass="right mdi mdi-alert mdi-24"
            noClose
            noScroll
            ref={node => { modal = node; }}
            {...props}
            renderFooter={() => (
                <div>
                    <a href="#" className="button flat small close-reveal-modal btn-clean-margin">{formatMessage('confirm_window/cancel_button')}</a>
                    <a href="#" className="button flat-inst-secondary small btn-clean-margin action" onClick={handleConfirm}>{formatMessage('confirm_window/confirm_button')}</a>
                </div>
            )}
        />
    );
}

ConfirmWindow.propTypes = {
    id: PropTypes.string,
    className: PropTypes.string,
    title: PropTypes.string,
    children: PropTypes.element,
    render: PropTypes.func,
    onConfirm: PropTypes.func.isRequired,
    onClosed: PropTypes.func
};

ConfirmWindow.defaultProps = {
    id: '', /*'modal-base-confirm-tp'*/
    className: 'tiny',
    title: '',
    onConfirm: () => {}
};

export default ConfirmWindow
