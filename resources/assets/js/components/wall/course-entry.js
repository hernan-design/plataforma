// resources/assets/js/components/wall/course-entry.js
import React from 'react';
import Misc from '../../helpers/misc';
import laroute from '../../helpers/laroute';

// app componenets

const createMarkup = (markup) => {
  return {__html: markup};
}

const CourseEntry = ({ contentRef, ...props }) => (
    <ul className="inline-list-grid align-top">
        { props.imagenContenido &&
            <li className="has-image">
                <a
                    href={Misc.urlFull(laroute.route('aprende.categoria.curso', {
                        type: props.urlClaseContenido,
                        category: props.urlTipoContenido,
                        course: props.urlContenidoMuro
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
                    <a href={Misc.urlFull(laroute.route('aprende.categoria.curso', {
                        type: props.urlClaseContenido,
                        category: props.urlTipoContenido,
                        course: props.urlContenidoMuro
                    }))}
                    >{ props.tituloMuro }</a>
                </h5>
                <div className="container-more" ref={typeof contentRef === 'function' ? contentRef : null} dangerouslySetInnerHTML={createMarkup(props.textoContenidoMuro)} />
                { props.nombreTipoContenido &&
                    <p className="label-category-entry">{ props.nombreTipoContenido }</p>
                }
                {/*<ul className="card-tags-entry inline-list-items inst-color-secondary text-md">
                    <li><a>#Tecnologia</a></li>
                    <li><a>#Robotica</a></li>
                    <li><a>#biotecnologia</a></li>
                </ul>*/}
            </div>
        </li>
    </ul>
);

export default CourseEntry
