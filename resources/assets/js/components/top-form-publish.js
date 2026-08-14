// resources/assets/js/components/top-form-publish.js
import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { strToNickname, imageDefault } from '../helpers/misc';
import { thumbs } from '../helpers/states';
import $ from 'jquery';

const TopFormPublish = ({ className, ownerData, handleClose, type, iconPublish, labelPublish }) => {
    switch(type){
        case 'post':
            iconPublish = 'mdi-pin';
            labelPublish = 'Post';
            break;
        case 'event':
            iconPublish = 'mdi-calendar';
            labelPublish = 'Evento';
            break;
        case 'forum':
            iconPublish = 'mdi-forum';
            labelPublish = 'Foro';
            break;
        default:
            iconPublish = '';
            labelPublish = '';
    }

    const tooltipToRef = el => {
        let $el = $(el);

        if( $el.length && ({}).hasOwnProperty.call($.fn, 'foundation') ) {
            $(document).foundation('tooltip', 'reflow');
        }else {
            $(document).foundation('tooltip', 'off');
        }
    }

    return(
        <div className={`wrap-top-form-publish ${className}`} style={styles.topPanelMain}>
            <div className="row">
                {ownerData && Object.keys(ownerData).length && (
                    <div className="mobile-6 columns">
                        <ul className="inline-list-grid align-center gray-dark-text">
                            <li className="has-image">
                                <img src={ownerData.imagenUsuario} alt={strToNickname(ownerData.nicknameUsuario)} className="rounded-img size35" onError={e => { imageDefault(e.target, thumbs.avatar()) }} />
                            </li>
                            <li>
                                <span className="text-md">{ownerData.nombreUsuario}</span>
                            </li>
                        </ul>
                    </div>
                )}
                <div className="mobile-6 columns">
                    <ul className="inline-list-grid align-center text-right">
                        {iconPublish &&
                            <li>
                                <span data-tooltip aria-haspopup="true" className="action-hover-circle tiny icon-18 tip-top radius" title={labelPublish} ref={node => { tooltipToRef(node); }}>
                                    <i className={`mdi ${iconPublish}`}></i>
                                </span>
                            </li>
                        }
                        <li className="has-image">
                            <a href="#" title="cerrar" onClick={handleClose}>
                                <span className="action-hover-circle tiny icon-18">
                                    <i className="mdi mdi-close"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    );
};

TopFormPublish.propTypes = {
    className: PropTypes.string,
    ownerData: PropTypes.object.isRequired,
    type: PropTypes.string.isRequired,
    handleClose: PropTypes.func,
    iconPublish: PropTypes.string,
    labelPublish: PropTypes.string
};

TopFormPublish.defaultProps = {
    className: '',
    handleClose: () => {},
    iconPublish: '',
    labelPublish: '',
    type: ''
};

const mapStateToProps = state => ({
    ownerData: state.session.user
});

const styles = {
    topPanelMain: {
        marginBottom: '15px'
    }
};

export default connect(mapStateToProps)(TopFormPublish)
