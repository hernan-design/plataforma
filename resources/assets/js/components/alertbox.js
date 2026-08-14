import React, { Component } from 'react';
import PropTypes from 'prop-types';
import $ from 'jquery';
import { isObject } from 'lodash';
import { actionCreators } from '../stores/error-message';

const errorItems = (errors) => (
    <ul>
        {Object.keys(errors).map(key => <li key={key}>{errors[key][0]}</li>)}
    </ul>
);

class AlertBox extends Component {

    constructor (props, context) {
        super(props, context);

        const { store:propsStore } = props;
        this.store = propsStore || context.store;

        // initial states
        this.state = {
            type: props.type,
            message: props.message,
            alert: props.alert
        };

        // binding event handlers
        this._handleClose = this._handleClose.bind(this);
    }

    componentDidMount () {
        $(this.alertBox).slideDown( this.props.speedOpen );
        this.closeCountdown();
        // $(document).foundation('alert', 'reflow');
    }

    componentWillReceiveProps (nextProps) {
        if(nextProps !== this.props) {
            this.setState({
                type: nextProps.type,
                message: nextProps.message,
                alert: nextProps.alert
            });
        }
    }

    componentDidUpdate() {
        $(this.alertBox).slideDown( this.props.speedOpen );
        this.closeCountdown();
        // $(document).foundation('alert', 'reflow');
    }

    _handleClose (e) {
        e.preventDefault();

        $(this.alertBox).slideUp( this.props.speedClose );

        this.cleanAlert();
    }

    closeCountdown () {
        if(this.props.closeTime) {
            setTimeout(() => {
                $(this.alertBox).slideUp( this.props.speedClose );

                this.cleanAlert();
            }, this.props.closeTime);
        }
    }

    cleanAlert() {
        if(this.store) {
            this.store.dispatch(actionCreators.cleanError());

            return;
        }
        this.setState({ alert: false });
    }

    alertBoxRef (node) {
        this.alertBox = node;
    }

    render() {
        if(!this.state.alert) {
            return null;
        }

        const { store, alert, message, type, close, closeTime, speedOpen, speedClose, className, ...rest } = this.props;

        return (
            <div
                data-alert
                className={`${className} ${this.state.type}`}
                tabIndex={0}
                style={styles.alertBox}
                ref={ node => { this.alertBoxRef(node); }}
                {...rest}
            >
                <i className="icon-alert"></i>
                { isObject(this.state.message) ?
                    <span>{errorItems(this.state.message)}</span>
                    :
                    <span dangerouslySetInnerHTML={{ __html: this.state.message }} />
                }
                { close && <a href="#" className="close" onClick={this._handleClose}>&times;</a> }
            </div>
        );
    }
}

AlertBox.contextTypes = {
    store: PropTypes.object
};

AlertBox.PropTypes = {
    className: PropTypes.string,
    message: PropTypes.oneOfType([
        PropTypes.string,
        PropTypes.object,
        PropTypes.array
    ]),
    type: PropTypes.string,
    close: PropTypes.bool,
    closeTime: PropTypes.number,
    alert: PropTypes.bool,
    speedOpen: PropTypes.oneOfType([
        PropTypes.string,
        PropTypes.number
    ]),
    speedClose: PropTypes.oneOfType([
        PropTypes.string,
        PropTypes.number
    ])
};

AlertBox.defaultProps = {
    'className': 'alert-box-tp',
    'message': '',
    'type': '',
    'close': true,
    'closeTime': 0,
    'speedOpen': 400,
    'speedClose': 400,
    'alert': true
};

const styles = {
    alertBox: { display: 'none' }
};

export default AlertBox
