// resources/assets/js/pages/chat.js
import React from 'react';
import Messaging from '../components/chat/messaging';
import NoSSR from 'react-no-ssr';

const Chat = () => (
  <div id="chat-browse-wrap">
    <div className="row panel radius no-padding" id="container-chat">
      <NoSSR>
        <Messaging />
      </NoSSR>
    </div>
  </div>
);

export default Chat
