// resources/assets/js/components/forum/publishing-forum.js
import React from 'react';
import PropTypes from 'prop-types';
import { Switch, Route, Redirect } from 'react-router-dom';

// app components
import ButtonPublishForum from './button-publish-forum';
import FormForum from './form/form-forum';

const PublishingForum = ({ match, location, history }) => {

    // validated attributes
    const isModal = !!(
        location.state &&
        location.state.modal
    );
    const isPublishing = !!(
        location.state &&
        (location.state.publish ||
         location.state.edit)
    );

    const handleBack = (e) => {
        if(e) {
            e.preventDefault;
            e.stopPropagation();
        }

        if(match.params.category && match.params.category === 'general') {
            history.replace('/foro');
        }else {
            history.replace(`${match.url}`);
        }
    }

    return(
        <section className="content-publishing-forum">
            <Switch>
                { isModal && isPublishing &&
                    <Route path={`${match.url}`} render={props => (
                        <FormForum onClose={handleBack} categoryUrl={match.params.category} style={styles.choosingBox} {...props} />
                    )} />
                }
                <Route path={`${match.url}`} component={ButtonPublishForum} />
            </Switch>

            { isModal ?
                (<Route path={`${match.url}`} children={() => <span
                    className="overlight"
                    style={styles.overlight}
                    onClick={handleBack}
                />} />)
                :
                null
            }
        </section>
    );
};

PublishingForum.propTypes = {
    match: PropTypes.object.isRequired,
    location: PropTypes.object.isRequired,
    history: PropTypes.object.isRequired
};

// styles for component
const styles = {
    choosingBox: {
        position: 'relative',
        zIndex: 101
    },
    overlight: {
        display: 'block',
        position: 'fixed',
        width: '100%',
        height: '100%',
        top: 0,
        left: 0,
        background: 'rgba(0, 0, 0, .4)',
        zIndex: 100
    }
};

export default PublishingForum
