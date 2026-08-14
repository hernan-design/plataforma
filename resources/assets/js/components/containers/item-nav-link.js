// resources/assets/js/components/containers/item-nav-link.js
import React from 'react';
import PropTypes from 'prop-types';
import { Route, Link } from 'react-router-dom';
import { isEqual } from 'lodash';

const refCallback = ({ match, location, history }, { to }) => node => {
    if(node !== null) {
        if( match && match.isExact &&
            typeof to === 'object' &&
            !isEqual(to.state, location.state) &&
            history.action === 'POP'
        ) {
            node.click();
        }
    }
};

const ItemNavLink = ({
    to,
    location,
    label,
    activeClassName='active',
    className='',
    iconClass='',
    activeStyle={},
    isActive = (match) => !!match,
    exact,
    strict,
    ...props
}) => (
    <Route
        path={(typeof to === 'string') ? to : to.pathname}
        exact={exact}
        strict={strict}
        location={location}
        children={({ match, ...restRouter }) => (
            <li className={isActive(match, restRouter.location) ? activeClassName : ''}>
                <Link
                    to={to}
                    style={isActive(match, restRouter.location) ? activeStyle : {}}
                    className={`${className} ${isActive(match, restRouter.location) ? activeClassName : ''}`}
                    innerRef={ refCallback({ ...restRouter, match }, { to }) }
                >
                    {iconClass && <i className={iconClass}></i>}
                    <span>{label}</span>
                </Link>
            </li>
        )}
    />
);

ItemNavLink.propTypes = {
    to: PropTypes.oneOfType([
        PropTypes.string,
        PropTypes.shape({
            pathname:  PropTypes.string
        })
    ]).isRequired,
    location: PropTypes.object,
    label: PropTypes.oneOfType([
        PropTypes.string,
        PropTypes.object
    ]),
    activeClassName: PropTypes.string,
    className: PropTypes.string,
    iconClass: PropTypes.string,
    activeStyle: PropTypes.object,
    exact: PropTypes.bool
};

export default ItemNavLink
