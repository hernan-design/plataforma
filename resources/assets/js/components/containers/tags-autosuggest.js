// resources/assets/js/components/containers/tags-autosuggest.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import TagsInput from 'react-tagsinput';
import Autosuggest from 'react-autosuggest';
import Misc from '../../helpers/misc';
import laroute from '../../helpers/laroute';
import axios, { CancelToken } from 'axios';

// if (typeof window !== 'undefined') {
//     require('react-tagsinput/react-tagsinput.css');
// }

const autosuggestRenderInput = ({ addTag, suggestions, loadSuggestions, isLoading, ref:inputRef, ...props }) => {
    const renderSuggestionsContainer = ({ containerProps , children, query }) => {
        if( !children && !query ) {
            return null;
        }

        return(
            <div {...containerProps} className="autocomplete-content dropdown-content">
                {isLoading && <span className="gray-light-text">Cargando sugerencias ({query})...</span>}
                {!isLoading && children}
            </div>
        );
    };

    const handleOnChange = (e, {newValue, method}) => {
        if (method === 'enter') {
            e.preventDefault();
        } else {
            props.onChange(e);
        }
    }

    const storeInputRef = autosuggest => {
        if (autosuggest !== null) {
            inputRef(autosuggest.input);
        }
    };

    return (
        <Autosuggest
            ref={storeInputRef}
            suggestions={suggestions}
            shouldRenderSuggestions={(value) => value && value.trim().length > 0}
            renderSuggestion={(suggestion, {query, isHighlighted}) => <span className={isHighlighted && 'gray-light-alt-bg'}>{suggestion.value}</span>}
            renderSuggestionsContainer={renderSuggestionsContainer}
            inputProps={{ ...props, onChange: handleOnChange }}
            getSuggestionValue={(suggestion) => suggestion.value}
            onSuggestionSelected={(e, {suggestion}) => {
                addTag(suggestion.value)
            }}
            onSuggestionsFetchRequested={loadSuggestions}
            onSuggestionsClearRequested={() => {}}
        />
    );
}

const defaultRenderLayout = (name, tags) => (tagComponents, inputComponent) => (
    <span>
      {tagComponents}
      {inputComponent}
      {name && <input type="hidden" name={name} value={tags} /> }
    </span>
);

class TagsAutosuggest extends Component {

    constructor(props) {
        super(props);

        // initial attributes
        this.requestCancel = null;
        this.lastRequestId = null;

        this.state = {
            tags: typeof props.defaultValue === 'string' && props.defaultValue.length ? props.defaultValue.split(',') : props.defaultValue || [],
            suggestions: [],
            isLoading: false
        };

        // binding event handlers
        this.handleChange = this.handleChange.bind(this);
        this.handleClick = this.handleClick.bind(this);
        this.loadSuggestions = this.loadSuggestions.bind(this);
    }

    componentDidMount() {
        if(this.tagsInput !== null) {
            this.tagsInput.div.addEventListener('click', this.handleClick, false);
        }
    }

    componentWillUnmount() {
        if(this.tagsInput !== null) {
            this.tagsInput.div.removeEventListener('click', this.handleClick);
        }
    }

    handleChange(tags) {
        this.setState({ tags });
    }

    handleInputChange(value) {
        if (value.length) {
            return this.refs.tagsinput.accept()
        }

        this.setState({tag: value})
    }

    handleClick(e) {
        if(this.tagsInput !== null) {
            this.tagsInput.focus();
        }
    }

    loadSuggestions({ value:term, reason }) {
        const { reqEndpoint } = this.props;
        let time = 500;

        // set time of countdown in zero, if the fecth request is not type typing
        if(reason !== 'input-changed') {
            time = 0;
        }

        // Cancel the previous request
        if(this.requestCancel) {
            this.requestCancel();
        }

        // Clear the last request time out
        if(this.lastRequestId !== null) {
            clearTimeout(this.lastRequestId);
        }

        this.setState({
            isLoading: true
        });

        this.lastRequestId = setTimeout(() => {

            axios.get(Misc.urlFull(laroute.route('tag.index')), {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
                cancelToken: new CancelToken(cancel => {
                    this.requestCancel = cancel;
                }),
                params: {
                    term
                }
            })
            .then(({ data:suggestions }) => {
                this.setState({
                    isLoading: false,
                    suggestions
                });
            })
            .catch(error => {
                this.setState({
                    isLoading: false,
                    suggestions: []
                });
            });

        }, time);
    }

    get buildInputProps() {
        return {
            className: 'react-tagsinput-input input',
            placeholder: this.props.placeholder,
            loadSuggestions: this.loadSuggestions,
            suggestions: this.state.suggestions,
            isLoading: this.state.isLoading
        }
    }

    get buildTagProps() {
        return {
            className: 'react-tagsinput-tag chip',
            classNameRemove: 'react-tagsinput-remove close'
        }
    }

    render() {
        const { placeholder, value, ...props } = this.props;
        const inputProps = this.buildInputProps;
        const tagProps = this.buildTagProps;

        return(
            <TagsInput
                ref={node => { this.tagsInput = node; }}
                renderLayout={defaultRenderLayout(this.props.name, this.state.tags)}
                addKeys={[9, 13, 188]}
                renderInput={autosuggestRenderInput}
                value={this.state.tags}
                onChange={this.handleChange}
                tagProps={tagProps}
                inputProps={inputProps}
                focusedClassName={'react-tagsinput--focused focus'}
                { ...props }
            />
        )
    }
}

TagsAutosuggest.propTypes = {
    name: PropTypes.string,
    className: PropTypes.string,
    currentValue: PropTypes.string,
    placeholder: PropTypes.string,
    onlyUnique: PropTypes.bool,
    disabled: PropTypes.bool,
    maxTags: PropTypes.number,
    reqEndpoint: PropTypes.string,
    defaultValue: PropTypes.oneOfType([
        PropTypes.array,
        PropTypes.string
    ])
}

TagsAutosuggest.defaultProps = {
    name: '',
    className: 'react-tagsinput chips',
    currentValue: '',
    placeholder: 'Agrega un tag',
    onlyUnique: true,
    disabled: false,
    maxTags: -1,
    reqEndpoint: '',
    defaultValue: []
}

export default TagsAutosuggest
