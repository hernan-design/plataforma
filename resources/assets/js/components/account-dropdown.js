// resources/assets/js/components/account-dropdown.js
import React, { Component } from "react";
import PropTypes from 'prop-types';
import $ from 'jquery';
import Misc, { strToNickname, imageDefault } from '../helpers/misc';
import { thumbs } from '../helpers/states';

class AccountDropdown extends Component {
    constructor (props) {
        super(props);

        this.nodeDrop = null;
        this.state = {
            hidden: props.hidden,
            autoclose: props.autoclose
        };
    }

    componentDidMount() {
        if( ({}).hasOwnProperty.call($.fn, 'foundation') ) {
            $(document).foundation('dropdown', 'reflow');
        }
    }

    componentWillUnmount() {
        if( ({}).hasOwnProperty.call($.fn, 'foundation') ) {
            $(this.nodeDrop).find('[data-dropdown]').foundation('dropdown', 'off');
        }
    }

    render () {
        const {id, hidden, autoclose, className } = this.props;

        return(
            <div
                id={id}
                className={`md-dropdown content drop-account ${className}`}
                data-dropdown-content
                aria-hidden={this.state.hidden}
                aria-autoclose={this.state.autoclose}
                ref={node => { this.nodeDrop = node; }}
            >
                <div className="card-user-info">
                    <ul className="inline-list-grid no-spacing align-center">
                        <li className="has-image">
                            <a href={ Misc.urlFull(this.props.urlProfile) } title={this.props.nombreUsuario} className="rounded-thumb no-outline">
                                <img src={this.props.imagenUsuario} alt={this.props.nombreUsuario} className="rounded-img size40" onError={e => { imageDefault(e.target, thumbs.avatar()) }} />
                            </a>
                        </li>
                        <li>
                            <h6 className="carduser-name-user bold-header clean-header inst-color-secondary">
                                <a href={ Misc.urlFull(this.props.urlProfile) } title={strToNickname(this.props.nicknameUsuario)}>{this.props.nombreUsuario}</a>
                            </h6>
                            <p className="text-sm dark-text linear-span">
                                <i className="mdi mdi-map-marker-radius mdi-16 gray-lighter-alt vcenter gutter-right"></i>
                                { this.props.nombreCiudad && `${this.props.nombreCiudad}, `}
                                { this.props.nombrePais && `${this.props.nombrePais}`}
                            </p>
                        </li>
                    </ul>
                </div>

                <ul className="list-info-data no-bullet text-xsm dark-text">
                    { this.props.profesionUsuario && (
                        <li>
                            <i className="mdi mdi-school mdi-16 gray-lighter-alt vcenter gutter-right"></i>
                            <span>{ this.props.profesionUsuario }</span>
                        </li>
                    )}
                    { this.props.nombreNivelEducacion && (
                        <li>
                            <i className="mdi mdi-briefcase mdi-16 gray-lighter-alt vcenter gutter-right"></i>
                            <span>{ this.props.nombreNivelEducacion }</span>
                        </li>
                    )}
                    { this.props.nombreEspecialidad && (
                        <li>
                            <i className="mdi mdi-lightbulb mdi-16 gray-lighter-alt vcenter gutter-right"></i>
                            <span>{ this.props.nombreEspecialidad }</span>
                        </li>
                    )}
                </ul>
            </div>
        );
    }
}

AccountDropdown.propTypes = {
    id: PropTypes.string.isRequired,
    className: PropTypes.string,
    hidden: PropTypes.bool,
    autoclose: PropTypes.bool
}

AccountDropdown.defaultProps = {
    className: 'radius drop-bottom small',
    hidden: true,
    autoclose: true
};

export default AccountDropdown
