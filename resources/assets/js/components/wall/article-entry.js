// resources/assets/js/components/wall/article-entry.js
import React from 'react';
import Misc from '../../helpers/misc';
import laroute from '../../helpers/laroute.js';

// app componenets

const createMarkup = (markup) => {
  return {__html: markup};
}

const ArticleEntry = ({ contentRef, ...props }) => (
    <ul className="inline-list-grid align-top">
        { props.imagenContenido &&
            <li className="has-image">
                <a
                    href={Misc.urlFull(laroute.route('blog.categoria.articulo', {
                        category: props.urlTipoContenido,
                        article: props.urlContenidoMuro
                    }))}
                    className="entry-thumb"
                >
                    <img src={ props.imagenContenido } alt={ props.tituloMuro } />
                </a>
            </li>
        }
        <li>
            <div className="text-description-entry">
                <h5 className="clean-top">
                    <a href={Misc.urlFull(laroute.route('blog.categoria.articulo', {
                            category: props.urlTipoContenido,
                            article: props.urlContenidoMuro
                        }))}
                    >{ props.tituloMuro }</a>
                </h5>
                <div className="gray-dark-text container-more" ref={typeof contentRef === 'function' ? contentRef : null} dangerouslySetInnerHTML={createMarkup(props.textoContenidoMuro)} />
                {/*<ul className="card-tags-entry inline-list-items inst-color-secondary text-md">
                    <li><a>#Tecnologia</a></li>
                    <li><a>#Robotica</a></li>
                    <li><a>#biotecnologia</a></li>
                </ul>*/}
            </div>
        </li>
    </ul>
);

export default ArticleEntry
