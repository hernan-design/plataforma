// resources/assets/components/payment/billing-data.js
import React from 'react';

const BillingData = ({ name, documentid, email, address, cellphone }) => (
	<div className="panel-payment-billing panel-content radius">
		<label className="label title text-dmd gray-dark-text">Datos de facturación</label>

		<div className="row">
			<div className="small-12 columns input-field">
				<input type="text" name="purchaser_name" id="purchaser_name" className="validate" defaultValue={ name } required={true} />
				<label htmlFor="purchaser_name">Nombre</label>
			</div>
		</div>
		<div className="row">
			<div className="small-12 columns input-field">
				<input type="text" name="purchaser_address" id="purchaser_address" className="validate" defaultValue={ address } required={true} />
				<label htmlFor="purchaser_address">Dirección</label>
			</div>
		</div>
		<div className="row">
			<div className="tablet-6 columns input-field">
				<input type="text" name="purchaser_cellphone" id="purchaser_cellphone" className="validate phone-mask-co" defaultValue={ cellphone } required={true} />
				<label htmlFor="purchaser_cellphone">Teléfono</label>
			</div>
			<div className="tablet-6 columns input-field">
				<input type="text" name="purchaser_email" id="purchaser_email" className="validate" defaultValue={ email } pattern="email" required={true} />
				<label htmlFor="email" data-error="El email es incorrecto">Email</label>
			</div>
		</div>
		{/*<div className="row">
			<div className="tablet-6 columns input-field">
				<select className="" defaultValue="">
					<option value="" disabled={true}>Tipo de identificación</option>
					<option value="1">opt 1</option>
					<option value="2">opt 2</option>
					<option value="3">opt 3</option>
				</select>
			</div>
			<div className="tablet-6 columns input-field">
				<input type="text" id="numero_identificacion" defaultValue={ documentid } className="indetification-mask" required={true} />
				<label htmlFor="numero_identificacion">Número</label>
			</div>
		</div>*/}
	</div>
);

export default BillingData
