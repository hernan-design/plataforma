// resources/assets/js/components/no-results.js
import React from 'react';
import PropTypes from 'prop-types';

const NoResults = ({ children, message = 'No hay resultados.', hasResults = true }) => (
    <div className={`no-results-filter ${hasResults ? 'hidesoft': ''}`}>
        {
            children ||
            <p>{message}</p>
        }
    </div>
);

NoResults.propTypes = {
    children: PropTypes.element,
    message: PropTypes.string,
    hasResults: PropTypes.bool
};

export default NoResults;
