// resources/assets/js/components/wall/forum-entry.js
import React from 'react';
import Misc from '../../helpers/misc';
import laroute from '../../helpers/laroute.js';

// app componenets

const createMarkup = (markup) => {
  return {__html: markup};
}

const ForumEntry = ({ contentRef, ...props }) => (
    <ul className="inline-list-grid align-top">
        {/* props.imagenContenido &&
            <li className="has-image">
                <a
                    href={Misc.urlFull(laroute.route('foro.categoria.tema', {
                        category: props.urlTipoContenido,
                        theme: props.urlContenidoMuro
                    }))}
                    className="entry-thumb"
                >
                    <img src={ props.imagenContenido } alt={ props.tituloMuro } />
                </a>
            </li>
        */}
        <li>
            <div className="text-description-entry">
                <h5 className="clean-top">
                    <a href={Misc.urlFull(laroute.route('foro.categoria.tema', {
                            category: props.urlTipoContenido,
                            theme: props.urlContenidoMuro
                        }))}
                    >{ props.tituloMuro }</a>
                </h5>
                <div className="container-more" ref={typeof contentRef === 'function' ? contentRef : null} dangerouslySetInnerHTML={createMarkup(props.textoContenidoMuro)} />
                { props.nombreTipoContenido &&
                    <p className="label-category-entry">{ props.nombreTipoContenido }</p>
                }
                <ul className="card-tags-entry tags-icon-list">
                    { props.tagsContenido &&
                        props.tagsContenido.split(',').map((tag, indx) => (
                            <li key={indx}><span className="tag-item">{tag}</span></li>
                        ))
                    }
                </ul>
            </div>
        </li>
    </ul>
);

export default ForumEntry
