// resources/assets/js/components/forum/static/forum-filters.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { Link, withRouter } from 'react-router-dom';
import { isEqual } from 'lodash';

// app components
import ItemNavLink from '../../containers/item-nav-link';

const renderItemCategory = () => {
    return (ct) => (
        <ItemNavLink
            key={ct.codigoCategoriaForo}
            to={{ pathname: `/foro/${ct.urlCategoriaForo}` }}
            label={ct.nombreCategoriaForo}
            className="text-xmd"
        />
    );
};

const ForumFilters = ({ categories, match, location }) => {

    const validateActive = (linkMatch, linkLocation) => {
        if(!linkMatch) { return false; }

        return isEqual(linkLocation, location);
    };

    return(
        <div className="panel-content with-title radius-tablet-up forum-filters">
            <h6 className="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
                <span className="left">Filtros</span>
                <i className="mdi mdi-tune mdi-18 gray-light vcenter"></i>
            </h6>

            <ul className="side-navigation">
                <ItemNavLink
                    to={{ pathname: location.pathname }}
                    location={{
                        ...location,
                        search: ''
                    }}
                    label={`Recientes`}
                    className="text-xmd"
                    isActive={validateActive}
                />
                <ItemNavLink
                    to={{
                        pathname: location.pathname,
                        search: '?filterBy=more-commented'
                    }}
                    location={{
                        ...location,
                        search: '?filterBy=more-commented'
                    }}
                    label={`Más comentados`}
                    className="text-xmd"
                    isActive={validateActive}
                />

                <li><a className="disabled"><hr className="no-margin" /></a></li>

                <ItemNavLink
                    to={{ pathname: `/foro`}}
                    label={`Principal`}
                    className="text-xmd"
                    exact
                />
                { categories.map(renderItemCategory()) }
            </ul>
        </div>
    );
};

ForumFilters.propTypes = {
    categories: PropTypes.arrayOf(PropTypes.object).isRequired,
    location: PropTypes.object.isRequired,
    match: PropTypes.object.isRequired,
    history: PropTypes.object.isRequired
};

ForumFilters.defaultProps = {
    categories: []
};

const mapStateToProps = state => ({
    categories: state.forum.categories
});

export default withRouter(connect(mapStateToProps)(ForumFilters))
