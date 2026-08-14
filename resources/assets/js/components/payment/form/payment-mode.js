// resources/assets/components/payment/payment-mode.js
import React from 'react';
import { Link } from 'react-router-dom';
import _tp from '../../../helpers/states';

const styles = {
	creditCardModeLabel: { height:'auto' },
	creditCardName: { textTransform: 'uppercase' }
}

const PaymentMode = ({ children }) => {

	return (
		<div className="panel-payment-mode panel-content radius">
			<label className="label title text-dmd gray-dark-text">Medio de pago</label>

			<div className="row">
				<div className="small-12 columns">
					<ul className="list-info-data no-bullet">
						<li>
							<input type="radio" name="payment_mode" id="credit_card_mode" className="with-gap" value="credit_card" defaultChecked required={true} />
							<label htmlFor="credit_card_mode" style={styles.creditCardModeLabel}><img src={ _tp.thumbs.creditCards() } alt="Tarjeta de credito" /></label>
						</li>
						{/*<li>
							<input type="radio" name="payment_mode" id="paypal_mode" className="with-gap" />
							<label htmlFor="paypal_mode">Paypal</label>
						</li>
						<li>
							<input type="radio" name="payment_mode" id="bank_deposit_mode" className="with-gap" />
							<label htmlFor="bank_deposit_mode">Depósito bancario</label>
						</li>*/}
					</ul>
				</div>
			</div>
			<div className="row">
				<div className="tablet-6 columns input-field">
					<input type="text" id="numero_tarjeta" data-stripe="number" className="validate credit-card-mask" pattern="card_dash" required={true} />
					<label htmlFor="numero_tarjeta" data-error="El número de la tarjeta es incorrecto.">Número de la tarjeta</label>
				</div>
				<div className="tablet-6 columns input-field">
					<input type="text" id="nombre_tarjeta" data-stripe="name" style={styles.creditCardName} required={true} />
					<label htmlFor="nombre_tarjeta">Nombre como aparece en la tarjeta</label>
				</div>
			</div>
			<div className="row">
				<div className="tablet-6 columns input-field">
					<input type="text" id="numero_seguridad_tarjeta" data-stripe="cvc" pattern="cvv" required={true} className="validate" />
					<label htmlFor="numero_seguridad_tarjeta" data-error="El número de seguridad de la tarjeta es incorrecto.">Número de seguridad</label>
				</div>
				<div className="tablet-6 columns input-field">
					<label className="active gray-dark-text">Fecha de vencimiento</label>
					<div className="row">
						<div className="medium-6 columns">
							<input type="text" id="mes_fecha_vence" placeholder="01" data-stripe="exp_month" pattern="[0-9]{2}" required={true} />
						</div>
						<div className="medium-6 columns">
							<input type="text" id="anio_fecha_vence" placeholder={new Date().getFullYear()} data-stripe="exp_year" pattern="full_year" required={true} />
						</div>
					</div>
				</div>
			</div>
			<div className="row">
				<div className="small-12 columns">
					<p className="save-section">
						<input type="checkbox" id="terms_conditions_payment" name="terminos" required={true} defaultChecked={false} />
						<label htmlFor="terms_conditions_payment" data-error="Debes aceptar los términos y condiciones" className="gray-dark-text">Acepto los <a href="#" className="sky-blue-text">términos y condiciones</a></label>
					</p>
				</div>
			</div>
			{ children }
		</div>
	);
};

export default PaymentMode
