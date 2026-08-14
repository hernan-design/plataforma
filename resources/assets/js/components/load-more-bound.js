import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { decorators } from '@orange-marmalade/paginate-this';

class LoadMoreBound extends Component {
    constructor(props) {
        super(props);

        this.state = {
            'isLoading': props.isLoading
        };
        // binding event handlers
        this.handleClick = this.handleClick.bind(this);
        this.handleScrollBound = this.handleScrollBound.bind(this);
    }

    componentDidMount() {
        window.addEventListener('scroll', this.handleScrollBound, false);
    }

    componentWillUnmount() {
        window.removeEventListener('scroll', this.handleScrollBound);
    }

    componentWillReceiveProps(nextProps) {
        if(this.props.isLoading !== nextProps.isLoading) {
            this.setState({ isLoading: nextProps.isLoading });
        }
    }

    handleClick(e) {
        e.preventDefault();
        const { pageActions, hasNextPage } = this.props;

        if(hasNextPage && !this.state.isLoading) {
            pageActions.next();
        }
    }

    handleScrollBound() {
        const { pageActions, hasNextPage } = this.props;
        const scrollPosition = window.scrollY + window.innerHeight;
        const nodeBoundOffset = this.nodeBound && this.nodeBound.offsetTop;

        if(
            nodeBoundOffset &&
            (scrollPosition - 50) >= nodeBoundOffset &&
            hasNextPage &&
            !this.state.isLoading
        ) {
            pageActions.next();
        }
    }

    render() {
        const { isButton, nameButton, isLoading, hasNextPage } = this.props;

        if(isButton) {
            return( (hasNextPage && !isLoading) ?
                <a href="#" onClick={this.handleClick} className="button expand xsmall btn-view-more white btn-resetc btn-clean-margin">{ nameButton }</a>
                :
                null
            );
        }

        return <span className="load-more-bound" style={styles.baseBound} ref={node => { this.nodeBound = node }}></span>
    }
}

LoadMoreBound.propTypes = {
    isButton: PropTypes.bool,
    nameButton: PropTypes.string,
    isLoading: PropTypes.bool.isRequired,
    pageActions: PropTypes.shape({
        next: PropTypes.func.isRequired
    }).isRequired,
    hasPreviousPage: PropTypes.bool,
    hasNextPage: PropTypes.bool.isRequired,
    currentPage: PropTypes.number.isRequired,
    totalPages: PropTypes.number.isRequired,
    listId: PropTypes.string.isRequired
};

LoadMoreBound.defaultProps = {
    isButton: false,
    nameButton: 'Mostrar más',
    isLoading: false,
    listId: ''
};

const styles = {
    baseBound: {
        display: 'block',
        visibility: 'hidden',
        width: '0px',
        height: '0px'
    }
}

export default decorators.paginate(LoadMoreBound)
