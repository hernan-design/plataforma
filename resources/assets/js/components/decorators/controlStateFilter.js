// resources/assets/js/components/decorators/controlStateFilter.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { List, Set } from 'immutable';

export default function controlStateFilter(WrapperList) {
    class WrapList extends Component {
        constructor(props) {
            super(props);

            // refresh results
            this.refreshResults(props);
        }

        componentWillReceiveProps(nextProps) {
            if(
                this.props.location !== nextProps.location &&
                nextProps.history.action !== 'POP'
            ) {
                const currentFilter = this.getChannelFilter(this.props.location, this.props.field);
                const nextFilter = this.getChannelFilter(nextProps.location, this.props.field);
                if (currentFilter === nextFilter && nextProps.location && nextProps.location.state && nextProps.location.state.modal) {
                    return;
                }
                this.refreshResults(nextProps, 100);
            }
        }

        getChannelFilter(location, field) {
            let stateFilter = (location && location.state && ({}).hasOwnProperty.call(location.state, field))
                ? location.state[field]
                : (location && location.pathname ? location.pathname.replace(/^\/comunidad\/?/, '') : '');

            if (stateFilter) {
                stateFilter = stateFilter.replace(/\/(create|edit).*$/i, '').replace(/^(create|edit).*$/i, '');
                if (stateFilter === 'general') {
                    stateFilter = '';
                }
            }
            return stateFilter || '';
        }

        refreshResults(props, timeout = 0) {
            const { loadByState, location, field } = props;
            const stateFilter = this.getChannelFilter(location, field);

            loadByState(stateFilter, timeout);
        }

        shouldComponentUpdate(nextProps) {
            const { ids, isLoading, shouldUpdate } = this.props;

            return !!(!ids.equals(nextProps.ids) ||
                isLoading !== nextProps.isLoading ||
                shouldUpdate(this.props, nextProps));
        }

        render() {
            const { ids, ...props } = this.props;

            return (
                <WrapperList ids={ids.toArray()} {...props} />
            );
        }
    }

    WrapList.propTypes = {
        location: PropTypes.object.isRequired,
        history: PropTypes.object.isRequired,
        field: PropTypes.string.isRequired,
        listId: PropTypes.string.isRequired,
        loadByState: PropTypes.func.isRequired,
        results: PropTypes.arrayOf(PropTypes.object),
        ids: PropTypes.oneOfType([
            PropTypes.instanceOf(List),
            PropTypes.instanceOf(Set)
        ]).isRequired,
        isLoading: PropTypes.bool,
        shouldUpdate: PropTypes.func
    };

    WrapList.defaultProps = {
        loadByState: () => {},
        results: [],
        isLoading: false,
        shouldUpdate: () => false
    };

    return WrapList;
}
