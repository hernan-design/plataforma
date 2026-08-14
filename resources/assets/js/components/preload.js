import React, { Component } from 'react';
import PropTypes from 'prop-types';
import $ from 'jquery';
// import ProcessImage from 'react-imgpro';

class Preload extends Component {
    constructor(props) {
        super(props);

        // initial attributes
        const { preload } = props;
        this.PreloadComp = typeof preload === 'function' ? preload() : preload;
    }

    // componentWillReceiveProps(nextProps) {
    //     this.PreloadComp = typeof nextProps.preload === 'function' ? nextProps.preload() : nextProps.preload;

    //     if(this.PreloadComp) {
    //         this.forceUpdate();
    //     }
    // }

    componentDidMount() {
        const PreloadComp = this.PreloadComp;

        if( PreloadComp.s && $(PreloadComp.s.node).length ) {

            this.props.width && PreloadComp.s.node.setAttribute('width', this.props.width);
            this.props.height && PreloadComp.s.node.setAttribute('height',this.props.height);
            $(this.preloadRef).html(PreloadComp.s.node);
        }
    }

    componentWillUnmount() {
        const PreloadComp = this.PreloadComp;

        if( PreloadComp.s && $(PreloadComp.s.node).length ) {
            $(PreloadComp.s.node).remove();
            PreloadComp.stop();
        }
    }

    shouldComponentUpdate() {
        return false;
    }

    render() {
        const { className, image, width, height, preload, ...props } = this.props;
        const PreloadComp = this.PreloadComp;

        return (
            <div className={`preloader-shape ${className}`} ref={node => { this.preloadRef = node; }} {...props}>
                { image ?
                  <img src={image} width={width} height={height} />
                  :
                  null
                }
            </div>
        );
    }
};

Preload.propTypes = {
    className: PropTypes.string,
    preload: PropTypes.oneOfType([
        PropTypes.element,
        PropTypes.bool,
        PropTypes.func
    ]),
    image: PropTypes.string,
    width: PropTypes.oneOfType([
        PropTypes.number,
        PropTypes.string
    ]),
    height: PropTypes.oneOfType([
        PropTypes.number,
        PropTypes.string
    ])
};

Preload.defaultProps = {
    className: '',
    preload: false,
    image: '',
    width: null,
    height: null
};

export default Preload
