// resources/assets/js/components/tags-list.js
import React from 'react';

const TagsList = ({ tags = '', className = '' }) => (
    <ul className={`tags-icon-list ${className}`}>
        { tags &&
            tags.split(',').map((tag, indx) => (
                <li key={indx}><span className="tag-item">{tag}</span></li>
            ))
        }
    </ul>
);

export default TagsList;
