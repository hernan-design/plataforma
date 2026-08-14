// resources/assets/js/components/containers/base-modal.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import $ from 'jquery';
import {
    formatMessage,
    noCloseModal,
    noScrollModal
} from '../../init-app';

class BaseModal extends Component {
    constructor(props) {
        super(props);

        // bind event handlers
        this.handleClosed = this.handleClosed.bind(this);
    }

    componentDidMount() {
        const $nodeModal = $(this.nodeModal);

        if( ({}).hasOwnProperty.call($.fn, 'foundation') ) {
            $(document).foundation('reveal', 'reflow');

            this.props.noClose && noCloseModal(this.nodeModal);
            this.props.noScroll && noScrollModal(this.nodeModal);

            $nodeModal.foundation('reveal', 'open');
            $nodeModal.on('closed.fndtn.reveal', this.handleClosed);
        }
    }

    componentWillUnmount() {
        const $nodeModal = $(this.nodeModal);

        $nodeModal.foundation('reveal', 'off');
        $nodeModal.off('closed.fndtn.reveal', this.handleClosed);
    }

    shouldComponentUpdate() {
        return false;
    }

    handleClosed() {
        this.props.onClosed && this.props.onClosed();
    }

    render() {
        const { id, className, title, iconClass, children, render, renderFooter, noClose, noScroll, ...props } = this.props;
        let settings = {}
        if(noClose) { settings['data-noclose'] = true; }
        if(noScroll) { settings['data-noscroll'] = true; }

        return(
            <div
                className={`reveal-modal-main clearfix ${className}`}
                data-reveal
                ref={node => { this.nodeModal = node; }}
                {...settings}
            >
                {/* Title modal */}
                <div className="title-modal-top">
                    <ul className="inline-list-grid">
                        <li><h4 className="inner-title-modal">{title}</h4></li>
                        {iconClass && <li className="short-col"><i className={iconClass}></i></li>}
                    </ul>
                </div>
                {/* Content modal */}
                <div className="content-modal">
                    { children ?
                        children :
                        (typeof render === 'function' ?
                            render(props) :
                            null
                        )
                    }
                </div>
                {/* Footer modal */}
                { renderFooter &&
                    (<div className="footer-modal">
                        { renderFooter(props) }
                    </div>)
                }
                {!noClose && <a className="close close-reveal-modal">&#215;</a>}
            </div>
        );
    }
}

BaseModal.propTypes = {
    id: PropTypes.string,
    className: PropTypes.string,
    title: PropTypes.string,
    children: PropTypes.element,
    render: PropTypes.func,
    renderFooter: PropTypes.func,
    onClosed: PropTypes.func,
    noClose: PropTypes.bool,
    noScroll: PropTypes.bool,
    iconClass: PropTypes.string
};

BaseModal.defaultProps = {
    id: '', /*'modal-base-confirm-tp'*/
    className: 'modal-base-material tiny',
    title: '',
    noClose: false,
    noScroll: false,
    iconClass: ''
};

export default BaseModal
