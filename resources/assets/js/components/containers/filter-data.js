// resources/assets/js/components/containers/filter-data.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { formToJson } from '../../helpers/misc';
import { withRouter } from 'react-router-dom';
import qs from 'qs';

// app components
import filterData from '../decorators/filterData';
import Form from './form';

class FilterData extends Component {
    constructor(props) {
        super(props);

        // initial attributes
        this.lastSearch = null;

        // initial state
        this.state = {
            isSearching: false,
            filters: props.dataFilters
        }

        // binding event handlers
        this.handleChange = this.handleChange.bind(this);
        this.handleClean = this.handleClean.bind(this);
    }

    componentDidMount() {
        const cleaners = this.formEl.querySelectorAll('.clean-filters');

        cleaners.forEach(cleanEl => {
            cleanEl.addEventListener('click', this.handleClean, false);
        });
    }

    componentWillUnmount() {
        const cleaners = this.formEl.querySelectorAll('.clean-filters');

        cleaners.forEach(cleanEl => {
            cleanEl.removeEventListener('click', this.handleClean, false);
        });
    }

    componentWillReceiveProps(nextProps) {
        const { history, location } = this.props;

        if(nextProps.dataFilters !== this.props.dataFilters) {
            this.updateFilters(nextProps.dataFilters);
        }

        // if(nextProps.filters !== this.props.filters) {

        //     history.push({
        //         ...location,
        //         search: qs.stringify(nextProps.filters, { addQueryPrefix:true })
        //     });
        // }
    }

    handleClean(e) {
        e.preventDefault();
        const { dataFilters, filters } = this.props;

        // reset fields
        this.formObj.resetFields();

        let cleanFilters = {...this.state.filters};
        for(let n in cleanFilters) {
            cleanFilters[n] = undefined;
        }

        this.updateFilters({ ...dataFilters, ...cleanFilters });
    }

    handleChange(e) {
        const field = e.target;
        e.persist();

        this.verifyFieldValue(field, e.nativeEvent.type)
        .then(value => {
            if(field.name) {
                if(!value) {
                    this.updateFilters(field.name, undefined);
                }else if(field.type === 'checkbox' && typeof value !== 'boolean') {
                    this.updateFilters(field.name, value, true);
                }else {
                    this.updateFilters(field.name, value);
                }
            }
        });

        if(typeof this.props.onChange === 'function') {
            this.props.onChange(e);
        }
    }

    updateFilters (nameOrFilters, value, toggle = false) {
        const { pageActions, onFilter } = this.props;
        const nextFilters = typeof nameOrFilters === 'object' ? nameOrFilters : { [nameOrFilters]: value };

        this.setState(prevState => ({
            filters: {
                ...prevState.filters,
                ...nextFilters
            }
        }), () => {
            pageActions.resetResults([]);

            if(toggle && typeof nameOrFilters === 'string') {
                pageActions.toggleFilterItem(nameOrFilters, value);

            }else {
                pageActions.setFilters(this.state.filters);
            }

            // run filter callback
            if(onFilter) {
                onFilter(this.state.filters);
            }
        });
    }

    verifyFieldValue(field, eventType) {

        return new Promise(resolve => {
            let value = field.value;

            // verify the checkbox when they are unchecked
            if(field.type === 'checkbox' && value === 'on') {
                value = field.checked;
                resolve(value);

            }else if(eventType === 'input') {
                // delay the change value when the value was typed
                if(this.lastSearch !== null) {
                    clearTimeout(this.lastSearch);
                }

                this.lastSearch = setTimeout(() => {
                    resolve(value);
                }, 500);

            }else {
                resolve(value);
            }
        });
    }

    render() {
        const {
            id,
            className,
            children,
            listId,
            pageActions,
            onChange,
            isLoading,
            filters,
            stale,
            sort,
            sortReverse,
            dataFilters,
            onFilter,
            history,
            location,
            match,
            ...props
        } = this.props;

        return(
            <Form
                id={id}
                className={className}
                onChange={this.handleChange}
                formRef={node => { this.formEl = node; }}
                ref={form => { this.formObj = form; }}
                {...props}
            >
                {children}
            </Form>
        );
    }
}

FilterData.propTypes = {
    listId: PropTypes.string.isRequired,
    pageActions: PropTypes.shape({
        setFilter: PropTypes.func.isRequired,
        setFilters: PropTypes.func.isRequired,
        toggleFilterItem: PropTypes.func.isRequired,
        resetFilters: PropTypes.func.isRequired
    }).isRequired,
    id: PropTypes.string.isRequired,
    className: PropTypes.string,
    onChange: PropTypes.func,
    isLoading: PropTypes.bool.isRequired,
    filters: PropTypes.object.isRequired,
    dataFilters: PropTypes.object,
    onFilter: PropTypes.func,
    history: PropTypes.object.isRequired,
    location: PropTypes.object.isRequired
}

FilterData.defaultProps = {
    isLoading: false,
    filters: {},
    listId: '',
    className: 'box-filters-choice',
    dataFilters: {}
};

export default withRouter(filterData(FilterData))
