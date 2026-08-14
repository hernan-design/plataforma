// resources/assets/js/components/containers/item-nav-link.js
import React from 'react';
import PropTypes from 'prop-types';
import { Route, Link } from 'react-router-dom';

const ItemCheckLink = ({
    to,
    location,
    label,
    activeClassName='active',
    className='',
    iconClass='',
    activeStyle={},
    exact,
    ...props
}) => (
    <Route path={(typeof to === 'string') ? to : to.pathname} exact={exact} children={({ match }) => (
        <li className={match ? activeClassName : ''}>
            <Link to={to} style={match ? activeStyle : {}} className={`${className} ${match ? activeClassName : ''}`}>
                {iconClass && <i className={iconClass}></i>}
                <span>{label}</span>
            </Link>
        </li>
    )} />
);

ItemCheckLink.propTypes = {
    to: PropTypes.oneOfType([
        PropTypes.string,
        PropTypes.object
    ]).isRequired,
    location: PropTypes.object,
    label: PropTypes.oneOfType([
        PropTypes.string,
        PropTypes.object
    ]),
    activeClassName: PropTypes.string,
    className: PropTypes.string,
    iconClass: PropTypes.string,
    activeStyle: PropTypes.object
};

export default ItemCheckLink
