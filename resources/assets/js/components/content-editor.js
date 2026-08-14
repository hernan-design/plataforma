// resources/assets/js/components/content-editor.js
import React from 'react';

// app components
import BaseEditor from './containers/base-editor';

let defaults = {
    minHeight: 100,
    toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
        ['para', ['ul', 'ol', 'paragraph', 'hr', 'height']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']]
    ],
    cleaner: {
        action: 'paste', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
        newline: '<br>', // Summernote's default is to use '<p><br></p>'
        keepHtml: true, // Remove all Html formats
        keepOnlyTags: ['<p>', '<br>', '<ul>', '<ol>', '<li>', '<b>', '<strong>', '<i>', '<a>', '<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>'], // If keepHtml is true, remove all tags except these
        keepClasses: false, // Remove Classes
        badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
        badAttributes: ['style', 'start'], // Remove attributes from remaining tags
        limitChars: false, // 0/false|# 0/false disables option
        limitDisplay: '', // text|html|both
        limitStop: false // true/false
    }
};
const ContentEditor = ({ options = {}, ...props }) => (
    <BaseEditor options={{ ...defaults, ...options }} {...props} />
);

export default ContentEditor;
