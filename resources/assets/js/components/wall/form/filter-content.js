// resources/assets/js/components/wall/form/filter-content.js
import React from 'react';
import { getModule } from '../../../helpers/states';

// apps component
import FilterData from '../../containers/filter-data';

const FilterContent = ({ listId, ...props }) => (
    <div className="panel-content with-title radius-tablet-up show-for-tablet-up">
        <h6 className="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
            <span className="left">Filtra por tipo de contenido</span>
            <i className="mdi mdi-tune mdi-18 gray-light vcenter"></i>
        </h6>

        <FilterData id={`form_filter_content`} listId={listId}>
            <ul className="side-nav-slide">
                <li>
                    <input type="checkbox" name="filter_content" id="filter_post_content" value={getModule('wall')} />
                    <label htmlFor="filter_post_content" className="check-right">
                        <span className="text-md">
                            <i className="mdi mdi-pin mdi-16 vcenter gray-light gutter-right"></i>
                            Post
                        </span> 
                    </label>
                </li>
                <li>
                    <input type="checkbox" name="filter_content" id="filter_event_content" value={getModule('calendar')} />
                    <label htmlFor="filter_event_content" className="check-right">
                        <span className="text-md">
                            <i className="mdi mdi-calendar mdi-16 vcenter gray-light gutter-right"></i>
                            Evento
                        </span>
                    </label>
                </li>

                <li>
                    <input type="checkbox" name="filter_content" id="filter_article_content" value={getModule('blog')} />
                    <label htmlFor="filter_article_content" className="check-right">
                        <span className="text-md">
                            <i className="mdi mdi-pen mdi-16 vcenter gray-light gutter-right"></i>
                            Artículo
                        </span>
                    </label>
                </li>
            </ul>
        </FilterData>
    </div>
);

export default FilterContent
