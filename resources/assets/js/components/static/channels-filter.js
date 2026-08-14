// resources/assets/js/components/static
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import $ from 'jquery';
import _ from 'lodash';

// app components
import ItemNavLink from '../containers/item-nav-link';

const renderItemChannel = (isInside=false) => {
    return (ch) => (
        <ItemNavLink
            key={ch.codigoCanal}
            to={{
                pathname: `/comunidad/${ch.urlCanal}`,
                state: {
                    channel: ch.urlCanal,
                    codChannel: ch.codigoCanal
                }
            }}
            label={ch.nombreCanal}
            className={isInside ? 'text-xmd lighter-text' : ''}
            iconClass={`mdi ${ch.canalAbierto ? 'mdi-pound' : 'mdi-lock'} gray-light ${isInside ? 'mdi-12' : 'mdi-14'} gutter-right`}
        />
    );
};

const renderItemCategory = (channels, location) => (
    (ct, i) => {
        const activeCategory = channels.findIndex(ch => (
            ch.codigoCategoriaCanal === ct.codigoCategoriaCanal &&
            location.state && location.state.channel === ch.urlCanal
        )) !== -1;

        return(
            <li key={ct.codigoCategoriaCanal} className={activeCategory || i === 0 ? 'active' : ''}>
                <a className={`collapsible-header ${activeCategory || i === 0 ? 'active' : ''}`}>{ct.nombreCategoriaCanal}</a>
                <div className="collapsible-body">
                    <ul className="side-navigation">
                        {
                            _.chain(channels)
                                .filter(ch => ch.codigoCategoriaCanal === ct.codigoCategoriaCanal)
                                .map(renderItemChannel(true))
                                .value()
                        }
                    </ul>
                </div>
            </li>
        );
    }
);

class ChannelsFilter extends Component {
    constructor(props) {
        super(props);
    }

    componentDidMount() {
        $(this.el).find('[data-collapsible]').collapsible();
    }

    render() {
        const { channels, categories, location } = this.props;

        return(
            <div className="panel-content with-title radius-tablet-up channels-filter" ref={node => { this.el = node; }}>

                <h6 className="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
                    <span className="left">Canales</span>
                    <i className="mdi mdi-file-tree mdi-18 gray-light vcenter"></i>
                </h6>

                <ul className="side-navigation" data-collapsible="expandable">
                    <ItemNavLink
                        key={0}
                        to={{
                            pathname: `/comunidad`,
                            state: {
                                channel: '',
                                codChannel: ''
                            }
                        }}
                        exact
                        label={`General`}
                        iconClass={`mdi mdi-pound gray-light mdi-14 gutter-right`}
                    />
                    {
                        _.chain(categories)
                            .map(renderItemCategory(channels, location))
                            .value()
                    }
                    {
                        _.chain(channels)
                            .filter(ch => !ch.codigoCategoriaCanal)
                            .map(renderItemChannel())
                            .value()
                    }
                </ul>
            </div>
        );
    }
}

ChannelsFilter.propTypes = {
    channels: PropTypes.arrayOf(PropTypes.object).isRequired,
    categories: PropTypes.arrayOf(PropTypes.object).isRequired,
    location: PropTypes.object.isRequired,
    match: PropTypes.object.isRequired,
    history: PropTypes.object.isRequired
};

const mapStateToProps = state => ({
    channels: state.channel.channels,
    categories: state.channel.categories
});

export default withRouter(connect(mapStateToProps)(ChannelsFilter))
