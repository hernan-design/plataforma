// resources/assets/js/components/spinner-loader.js
import React from 'react';
import PropTypes from 'prop-types';

const SpinnerLoader = ({ text, children }) => (
    <div className="wrapper-spinner" style={styles.spinnerParent}>
        <div className="inner-spinner">
            { text && <p className="dark-text normal-text">{text}</p> }
            { children ||
                <div className="loader">Loading...</div>
            }
        </div>
    </div>
);

SpinnerLoader.propTypes = {
    text: PropTypes.string,
    children: PropTypes.element
};

const styles = {
    spinnerParent: {
        'display': 'block',
        'position': 'absolute',
        'top': '0px',
        'left': '0px',
        'width': '100%',
        'minHeight': '50px',
        'height': '100%',
        'zIndex': '50'
    }
};

export default SpinnerLoader
