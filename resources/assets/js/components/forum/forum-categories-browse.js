// resources/assets/js/components/forum/forum-categories-browse.js
import React, { Component } from 'react';
import { connect } from 'react-redux';
import { formatMessage } from '../../init-app';
import { LIST_ID as listIdForums, dynamicRecipes as dynamicRecipeForums } from '../../stores/forum';

// app components
import ForumThemesList from './forum-themes-list';
import NoResults from '../no-results';

const renderCategories = (category) => (
    <dd key={category.codigoCategoriaForo}>
        <h6 className="gray-dark-text lighter-header">{category.nombreCategoriaForo}</h6>
        <ForumThemesList
            listId={`${listIdForums}_${category.urlCategoriaForo}`}
            canLoadMore={false}
            filterData={{
                url_categoria_foro: category.urlCategoriaForo
            }}
        />

    </dd>
);

class ForumCategoriesBrowse extends Component {
    constructor(props) {
        super(props);

        dynamicRecipeForums(props.categories, { replace:true });
    }

    shouldComponentUpdate(nextProps, nextState) {
        return (nextProps.categories !== this.props.categories);
    }

    render() {
        const { categories } = this.props;

        return(
            <dl id="forum-categories-browse">
                { categories.map(renderCategories) }
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
