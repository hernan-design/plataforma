import React from 'react';
import PropTypes from 'prop-types';

// app components
import ItemCheckLink from '../../containers/item-check-link';

const ChoosePublishing = ({ match, onClose, style, ownerData }) => {
    const handleClose = e => {
        e.preventDefault();
        e.stopPropagation();

        if(typeof onClose !== 'function') return false;

        onClose();
    };

    return(
        <div className="panel-content radius" style={style}>
            <p className="gray-base-text text-md">Escoge el tipo de publicación que quieres hacer</p>

            <ul className={"publishing-type-actions mobile-block-grid-2 tablet-block-grid-" + (ownerData.isAdmin ? "3" : "2")}>
                <ItemCheckLink
                    to={{ pathname: `${match.url}/post`, state: { modal: true } }}
                    label="Post"
                    iconClass="mdi mdi-pin gray-base mdi-42"
                    className="choice-publishing-type"
                />
                <ItemCheckLink
                    to={{ pathname: `${match.url}/forum`, state: { modal: true } }}
                    label="Foro"
                    iconClass="mdi mdi-forum gray-base mdi-42"
                    className="choice-publishing-type"
                />
                { ownerData.isAdmin ?
                    <ItemCheckLink
                        to={{ pathname: `${match.url}/event`, state: { modal: true } }}
                        label="Evento"
                        iconClass="mdi mdi-calendar gray-base mdi-42"
                        className="choice-publishing-type"
                    />
                    : null
                }
            </ul>

            <a href="#" className="content-close" onClick={handleClose}>&times;</a>
        </div>
    );
};

export default ChoosePublishing
