// resources/assets/js/components/like/like.js
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { composables, getLike } from '../../stores/like';
import Misc from '../../helpers/misc';
import { formatMessage } from '../../init-app';
import $ from 'jquery';

// app components
import WhoLikeThis from './wholike-this';

const Aux = (props) => props.children;
class Like extends Component {
    constructor(props) {
        super(props);

        // initial state
        this.state = {
            counterLikes: props.contadorLike,
            givingIlike: props.givingIlike
        };

        // bind event handlers
        this.handleLike = this.handleLike.bind(this);
    }

    componentWillReceiveProps(nextProps) {
        if(
            nextProps.contadorLike !== this.props.contadorLike ||
            nextProps.givingIlike !== this.props.givingIlike
        ) {
            this.setState({
                counterLikes: nextProps.contadorLike,
                givingIlike: nextProps.givingIlike
            });
        }
    }

    componentDidMount() {
        const { likeActions, parentSrcparams } = this.props;

        if( Misc.checkSession(false) && parentSrcparams ) {
            // fetch one like
            likeActions.fetchOneLike(parentSrcparams);
        }
    }

    handleLike(e) {
        e.preventDefault();

        const { likeActions, authLike, parentSrcparams, srcparams, codigoLike } = this.props;

        if( /*Misc.checkSession(false) &&*/ !this.state.givingIlike ) {
            if(!authLike) {
                likeActions.storeLike({ srcparams: parentSrcparams });
            }else if(codigoLike) {
                likeActions.destroyLike({ srcparams });
            }
        }
    }

    render() {
        const { idDrop, valueTxt, noTextLike, authLike, iconSize, parentSrcparams, listId, dropOptions } = this.props;
        const { counterLikes, givingIlike } = this.state;

        const options = {
            align: 'top',
            is_hover: true,
            hover_timeout: 500,
            ...dropOptions
        }
        const _dropOptions = JSON.stringify(options).replace(
            /([{}"])|(,)/g,
            (str, p1) => (typeof p1 !== 'undefined' ? '': ';')
        );

        return(
            <div>
                <WhoLikeThis
                    id={idDrop}
                    srcparams={parentSrcparams}
                    authLike={authLike}
                    counterLikes={counterLikes}
                    listId={listId}
                />
                <a
                    href="#"
                    onClick={this.handleLike}
                    className={`TPlikelink ${givingIlike ? 'disabled' : ''} ${authLike ? 'ilike' : ''}`}
                    title={valueTxt}
                    data-dropdown={idDrop}
                    aria-controls={idDrop}
                    data-options={_dropOptions}
                >
                    { noTextLike ?
                        <div>
                            <i className={`mdi mdi-thumb-up-outline mdi-${iconSize} gutter-right vcenter`}></i>
                            <span className="data-count-likes">{counterLikes}</span>
                        </div>
                        :
                        valueTxt
                    }
                </a>
            </div>
        );
    }
}

Like.propTypes = {
    parentSrcparams: PropTypes.string.isRequired,
    srcparams: PropTypes.string,
    idDrop: PropTypes.string.isRequired,
    recipeId: PropTypes.string.isRequired,
    listId: PropTypes.string,
    likeActions: PropTypes.shape({
        fetchOneLike: PropTypes.func.isRequired,
        storeLike: PropTypes.func.isRequired,
        destroyLike: PropTypes.func.isRequired
    }),
    valueTxt: PropTypes.string,
    authLike: PropTypes.bool,
    noTextLike: PropTypes.bool,
    givingIlike: PropTypes.bool,
    contadorLike: PropTypes.number,
    iconSize: PropTypes.oneOf([12,14,16,18,21,24,30,36,42,48]),
    dropOptions: PropTypes.object,
    record: PropTypes.object
};

Like.defaultProps = {
    listId: '',
    codigoLike: null,
    srcparams: '',
    iconSize: 18,
    dropOptions: {},
    valueTxt: '',
    authLike: false,
    noTextLike: true,
    givingIlike: false,
    contadorLike: 0,
    record: {}
};

const mapStateToProps = (state, ownProps) => ({
    codigoLike: getLike(ownProps.recipeId, state).codigoLike || ownProps.codigoLike,
    authLike: getLike(ownProps.recipeId, state).authLike,
    valueTxt: ownProps.valueTxt || getLike(ownProps.recipeId, state).valueTxt,
    srcparams: getLike(ownProps.recipeId, state).srcparams || ownProps.srcparams,
    contadorLike: getLike(ownProps.recipeId, state).contadorLike,
    givingIlike: getLike(ownProps.recipeId, state).givingIlike,
    record: getLike(ownProps.recipeId, state)
});

const mapDispatchToProps = (dispatch, ownProps) => ({
    likeActions: bindActionCreators(composables(ownProps), dispatch)
});

export default connect(mapStateToProps, mapDispatchToProps)(Like)
