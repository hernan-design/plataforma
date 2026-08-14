// resources/assets/js/components/wall/post-entry.js
import React from 'react';

// app componenets

const createMarkup = (markup) => {
  return {__html: markup};
}

const PostEntry = ({ contentRef, ...props }) => (
    <ul className="inline-list-grid align-top">
        {/*<li className="has-image">
            <img src="http://via.placeholder.com/200x200" alt="" />
        </li>*/}
        <li>
            <div className="text-description-entry container-more" ref={typeof contentRef === 'function' ? contentRef : null} dangerouslySetInnerHTML={createMarkup(props.textoMuro)}>
                {/*<h5>Vestibulum et sem tristique, sollicitudin purus et, faucibus lacus. Duis volutpat ut diam vitae facilisis.</h5>
                <p className="gray-dark-text text-md">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris sed varius odio. Vestibulum vel risus vitae risus posuere aliquam. Nunc dictum pretium urna</p>
                <ul className="card-tags-entry inline-list-items inst-color-secondary text-md">
                    <li><a>#Tecnologia</a></li>
                    <li><a>#Robotica</a></li>
                    <li><a>#biotecnologia</a></li>
                </ul>*/}
            </div>
        </li>
    </ul>
);

export default PostEntry
