// resources/assets/js/components/notfound.js
import React from 'react';
import { Link, Route } from 'react-router-dom';

const NotFound = () => (
	<Route render={({ staticContext }) => {
		if (staticContext) {
			staticContext.statusCode = 404;
		}
		return (
			<div className="not-found">
				<h1>404</h1>
				<h2>Page not found!</h2>
				<p>
					<Link to="/">Go back to the main page</Link>
				</p>
			</div>
		);
	}} />
);

export default NotFound
