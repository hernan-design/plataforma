// resources/assets/js/components/decorators/controlListState.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { List, Set } from 'immutable';
import { isEqual } from 'lodash';

export default function controlListState(WrapperList) {
    class WrapList extends Component {
        constructor(props) {
            super(props);

            // refresh results
            this.refreshResults(props);
        }

        componentWillReceiveProps(nextProps) {
            const { filterData, filterValue } = this.props;

            if(
                !isEqual(filterData, nextProps.filterData) ||
                filterValue !== nextProps.filterValue
            ) {
                this.refreshResults(nextProps, 100);
            }
        }

        refreshResults(props, timeout = 0) {
            const { listActions, filterData, filterValue, resetStates } = props;

            if(typeof filterData === 'object') {
                if(resetStates) {
                    listActions.showByResetStates(filterData, timeout);
                }else {
                    listActions.showByStates(filterData, timeout);
                }
            }else if( filterData && filterValue ) {
                listActions.showByState(filterData, filterValue, timeout);
            }
        }

        shouldComponentUpdate(nextProps) {
            const { ids, isLoading, isAdding, shouldUpdate } = this.props;

            return (!ids.equals(nextProps.ids) ||
                isLoading !== nextProps.isLoading ||
                isAdding !== nextProps.isAdding ||
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
        filterData: PropTypes.oneOfType([
            PropTypes.string,
            PropTypes.object
        ]).isRequired,
        filterValue: PropTypes.any,
        listId: PropTypes.string.isRequired,
        listActions: PropTypes.shape({
            showByState: PropTypes.func,
            showByStates: PropTypes.func,
            showByResetStates: PropTypes.func
        }),
        results: PropTypes.arrayOf(PropTypes.object),
        ids: PropTypes.oneOfType([
            PropTypes.instanceOf(List),
            PropTypes.instanceOf(Set)
        ]).isRequired,
        isLoading: PropTypes.bool,
        isAdding: PropTypes.bool,
        resetStates: PropTypes.bool,
        shouldUpdate: PropTypes.func
    };

    WrapList.defaultProps = {
        listActions: {
            showByState: () => {},
            showByStates: () => {}
        },
        results: [],
        isLoading: false,
        isAdding: false,
        resetStates: false,
        shouldUpdate: () => false
    };

    return WrapList;
}
