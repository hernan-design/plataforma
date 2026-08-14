// resources/assets/js/components/static/social-networks.js
import React from 'react';
import { connect } from 'react-redux';

const SocialNetworks = ({ social }) => {
    if( !social.facebook &&
        !social.twitter &&
        !social.instagram &&
        !social.youtube
    ) {
        return null;
    }

    return(
        <div className="social-networks panel-content with-title radius-tablet-up show-for-xlarge-up">
            <h6 className="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
                <span className="left">Síguenos en</span>
                <i className="mdi mdi-share-variant mdi-18 gray-light vcenter"></i>
            </h6>

            <div className="social-container">
                <ul className="inline-list-grid">
                    { social.facebook &&
                        <li><a href={social.facebook} className="mdi mdi-facebook mdi-21 vcenter facebook" target="_blank" title="Facebook"></a></li>
                    }

                    { social.twitter &&
                        <li><a href={social.twitter} className="mdi mdi-close-outline mdi-21 vcenter twitter" target="_blank" title="X"></a></li>
                    }

                    { social.instagram &&
                        <li><a href={social.instagram} className="mdi mdi-instagram mdi-21 vcenter instagram" target="_blank" title="Instagram"></a></li>
                    }

                    { social.youtube &&
                        <li><a href={social.youtube} className="mdi mdi-youtube mdi-21 vcenter youtube" target="_blank" title="Youtube"></a></li>
                    }
                </ul>
            </div>
        </div>
    );
};

const mapStateToProps = state => ({
    social: state.session.institution.social
});

export default connect(mapStateToProps)(SocialNetworks)
