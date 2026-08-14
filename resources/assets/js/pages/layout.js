// resources/assets/js/pages/layout.js
import React from 'react';
import { connect } from 'react-redux';
import { renderRoutes } from 'react-router-config';
import qs from 'qs';

// app components
import AlertBox from '../components/alertbox.js';

const Layout = ({ route, location, errorMessage }) => (
    <div className="layout-components">
        {(errorMessage && errorMessage.showAlert) &&
            <AlertBox
                className="alert-box-tp radius"
                type={errorMessage.type}
                message={errorMessage.message}
                alert={errorMessage.showAlert}
            />
        }
        {renderRoutes(
            route.routes,
            { queryParams: qs.parse(location.search, { ignoreQueryPrefix: true }) }
        )}
    </div>
);

const mapStateToProps = (state) => ({
    errorMessage: state.errorMessage
});

export default connect(mapStateToProps)(Layout)
