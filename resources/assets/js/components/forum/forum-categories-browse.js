// resources/assets/js/components/forum/forum-categories-browse.js
import React, { Component } from 'react';
import { connect } from 'react-redux';
import { formatMessage } from '../../init-app';
import { LIST_ID as listIdForums, dynamicRecipes as dynamicRecipeForums } from '../../stores/forum';

import { isEqual } from 'lodash';

// app components
import ForumThemesList from './forum-themes-list';
import NoResults from '../no-results';

const renderCategories = (filterData = {}) => (category) => {
    const id = category.codigoCategoriaForo || category.codigo_categoria_foro;
    const name = category.nombreCategoriaForo || category.nombre_categoria_foro;
    const url = category.urlCategoriaForo || category.url_categoria_foro;

    return (
        <dd key={id}>
            <h6 className="gray-dark-text lighter-header">{name}</h6>
            <ForumThemesList
                listId={`${listIdForums}_${url}`}
                resetStates={true}
                canLoadMore={false}
                filterData={{
                    ...filterData,
                    url_categoria_foro: url
                }}
            />
        </dd>
    );
};

class ForumCategoriesBrowse extends Component {
    componentDidMount() {
        if(this.props.categories && this.props.categories.length) {
            dynamicRecipeForums(this.props.categories);
        }
    }

    componentDidUpdate(prevProps) {
        if(prevProps.categories !== this.props.categories && this.props.categories && this.props.categories.length) {
            dynamicRecipeForums(this.props.categories);
        }
    }

    shouldComponentUpdate(nextProps, nextState) {
        return (
            nextProps.categories !== this.props.categories ||
            !isEqual(nextProps.filterData, this.props.filterData)
        );
    }

    render() {
        const { categories, filterData = {} } = this.props;

        return(
            <dl id="forum-categories-browse">
                { categories.map(renderCategories(filterData)) }
                <NoResults hasResults={!!categories.length} message={formatMessage('forum/category/no_results')} />
            </dl>
        );
    }
}

ForumCategoriesBrowse.defaultProps = {
    categories: []
};

const mapStateToProps = state => ({
    categories: state.forum.categories
});

export default connect(mapStateToProps)(ForumCategoriesBrowse)
