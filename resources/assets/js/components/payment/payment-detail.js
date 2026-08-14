// resources/assets/components/payment/payment-detail.js
import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
// import { copCurrencyF } from '../../init-app';

const PaymentDetail = ({ title, pricing, detail }) => (
	<section className="content-payment-detail">
		<div className="panel-payment-detail panel-content radius">
			<label className="label title text-dmd gray-dark-text">Has elegido</label>

			<h4 className="inst-color-secondary">{ title }</h4>
			<span className="gray-base-text heavy-text text-xbg">{ parseFloat(pricing) }</span>

			<hr />

			<label className="label title text-dmd gray-dark-text">Incluye:</label>
			<ul className="list-info-data no-bullet">
				<li>
					<i className="mdi mdi-video mdi-14 gray-dark gutter-right"></i>
					<span className="dark-text text-sm">{ detail }</span>
				</li>
				{/*<li>
					<i className="mdi mdi-pen mdi-14 gray-dark gutter-right"></i>
					<span className="dark-text text-sm">1 artículo</span>
				</li>
				<li>
					<i className="mdi mdi-account-card-details mdi-14 gray-dark gutter-right"></i>
					<span className="dark-text text-sm">Acceso de por vida</span>
				</li>
				<li>
					<i className="mdi mdi-cellphone-android mdi-14 gray-dark gutter-right"></i>
					<span className="dark-text text-sm">Acceso en dispositivos móviles y TV</span>
				</li>
				<li>
					<i className="mdi mdi-certificate mdi-14 gray-dark gutter-right"></i>
					<span className="dark-text text-sm">Certificado de finalización</span>
				</li>*/}
			</ul>
		</div>

		<div className="panel-payment-resumen panel-content with-title radius">
			<h6 className="title-panel gray-dark-text thin-header">Resumen</h6>
			<table className="table-content">
				<tbody>
					<tr>
						<td className="black-text normal-text text-sm">Programación de Android desde Cero +35 horas</td>
						<td className="black-text normal-text text-sm text-right">$289.900</td>
					</tr>
					<tr>
						<td className="black-text normal-text text-sm">Total</td>
						<td className="inst-color-secondary normal-text text-sm text-right">$289.900</td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>
);

const mapStateToProps = (state) => ( Object.assign({}, state.payment) );

export default connect(mapStateToProps)(PaymentDetail)
