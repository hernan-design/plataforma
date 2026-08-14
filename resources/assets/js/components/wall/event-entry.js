// resources/assets/js/components/wall/event-entry.js
import React from 'react';
import moment from 'moment';
import Misc from '../../helpers/misc';
import laroute from '../../helpers/laroute';

// app componenets

const createMarkup = (markup) => {
  return {__html: markup};
}

const EventEntry = ({ contentRef, ...props }) => (
    <ul className="inline-list-grid align-top">
        { moment(props.fechaContenidoMuro).isValid() &&
            <li className="has-image">
                <a href={ Misc.urlFull(laroute.route('calendario.evento.show', { evento: props.urlContenidoMuro })) } className="as-block">
                    <div className="card-date">
                        <span className="major">{ moment(props.fechaContenidoMuro).format('DD') }</span>
                        <span>{ moment(props.fechaContenidoMuro).format('MMM') }</span>
                    </div>
                </a>
            </li>
        }
        <li>
            <div className="text-description-entry">
                <h5 className="clean-top">
                    <a href={ Misc.urlFull(laroute.route('calendario.evento.show', { evento: props.urlContenidoMuro })) }>{ props.tituloMuro }</a>
                </h5>
                <div className="container-more" ref={typeof contentRef === 'function' ? contentRef : null} dangerouslySetInnerHTML={createMarkup(props.textoContenidoMuro)} />
                { moment(props.horaContenidoMuro, 'HH:mm:ss').isValid() &&
                    <p className="clean-bottom gray-base-text text-sm normal-text">
                        <i className="mdi mdi-clock mdi-14 gutter-right"></i>
                        { moment(props.horaContenidoMuro, 'HH:mm:ss').format('hh:mm a') }
                    </p>
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

export default EventEntry
