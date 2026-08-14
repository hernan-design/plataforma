// resources/assets/js/components/decorators/renderPreloadItems.js
import React from 'react';
import { range } from 'lodash';
import { loadSVGItemAnimation } from '../../init-app';
import { thumbs } from '../../helpers/states';

// app components
import Preload from '../preload';

const renderPreloadItems = (count) => {
    return range(count).map(val => (
        <li key={val}>
            <Preload
                preload={ loadSVGItemAnimation }
                image={ thumbs.preloadItem() }
                width="100%"
                height="100%"
            />
        </li>
    ))
}

export default renderPreloadItems;
