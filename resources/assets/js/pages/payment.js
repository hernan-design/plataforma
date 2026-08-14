// resources/assets/js/pages/purchase.js
import React from 'react';

// app components
import PaymentForm from '../components/payment/form/payment-form';
import PaymentDetail from '../components/payment/payment-detail';

const Payment = (props) => {
	const { queryParams } = props;

	return (
		<section id="payment-wrapper">
			<div className="row">
				<div className="small-12 columns">
					<h2 className="lighter-header black-text">Confirmación y método de pago</h2>
					<hr className="h-hollow-top" />
				</div>
			</div>

			<div className="payment-confirm-content">
				<div className="row">
					<div className="medium-6 columns">
						<PaymentDetail />
					</div>

					<div className="medium-6 columns">
						<PaymentForm params={{ ...queryParams }} />
					</div>
				</div>
			</div>
		</section>
	);
};

export default Payment
