// resources/assets/components/payment/payment-form.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { actionCreators } from '../../../stores/payment';
import { Link } from 'react-router-dom';
import $ from 'jquery';
import Misc from '../../../helpers/misc';

// app components
import Form from '../../containers/form';
import BillingData from './billing-data';
import PaymentMode from './payment-mode';

class PaymentForm extends Component {

	constructor(props) {
		super(props);

		// binding event handlers
		this.handleToken = this.handleToken.bind(this);
	}

	handleToken(e, formData) {
		e.preventDefault();

		const dataStripe = this.formEl.querySelectorAll('[data-stripe]');

		dataStripe.forEach((el) => {
			(typeof formData['card'] === 'object') || (formData['card'] = {});

			formData['card'][el.getAttribute('data-stripe')] = el.value;
		});

		const cardToken = this.props.getCardToken(formData)

		// send data to server
		cardToken.then(() =>{
			this.props.sendData(this.props.params);
		});
	}

	render() {
		const { purchaser } = this.props;

		return(
			<Form
				id="form_payment_method"
				onSubmit={this.handleToken}
				formRef={(node) => { this.formEl = node; }}
			>
				<BillingData { ...purchaser } />
				<PaymentMode>
					<div className="row align-middle">
						<div className="mobile-6 tablet-4 columns">
							<input type="submit" value="Pagar" className="button small sky-blue radius btn-bold expand btn-clean-margin" />
						</div>
						<div className="mobile-6 tablet-8 columns">
							<p className="clean-bottom text-xsm gray-dark-text"><i className="mdi mdi-lock mdi-14 vcenter gutter-right"></i>Pago seguro</p>
						</div>
					</div>
				</PaymentMode>
			</Form>
		);
	}
}

// Typechecking props
PaymentForm.propTypes = {
	params: PropTypes.object,
	fields: PropTypes.any,
	purchaser: PropTypes.object.isRequired,
	getCardToken: PropTypes.func.isRequired,
	sendData: PropTypes.func.isRequired
};

PaymentForm.defaultProps = {
	params: {},
	fields: {},
	purchaser: {},
	getCardToken: () => {},
	sendData: () => {}
};

const mapStateToProps = (state) => ({
	purchaser: state.payment.purchaser,
	fields: state.form['form_payment_method'] || {}
});
const mapDispatchToProps = (dispatch) => bindActionCreators(actionCreators, dispatch);

export default connect(mapStateToProps, mapDispatchToProps)(PaymentForm)
