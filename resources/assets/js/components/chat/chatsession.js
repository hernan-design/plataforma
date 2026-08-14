// resources/assets/js/components/chat/chatsession.js
import React from 'react';
import Proptypes from 'prop-types';
import { format } from 'date-fns';

const ChatSession = props => {
  const { messages , currentUser } = props;
  return (
    <ul className="chat-messages">
      {messages.map((message) => {
        const time = format(new Date(`${message.updatedAt}`), 'HH:mm');
        if ( currentUser === message.senderId ){
            return (
                <li className="message panel radius message-own" key={message.id}>
                    <div>
                        <span className="user-id">{message.senderId} </span>
                        <span>{message.text}</span>
                    </div>
                    <span className="message-time">{time}</span>
                </li>
            )
        }else{
            return (
                <li className="message panel radius message-other" key={message.id}>
                    <div>
                        <span className="user-id">{message.senderId} </span>
                        <span>{message.text}</span>
                    </div>
                    <span className="message-time">{time}</span>
                </li>
            )
        }
      })}
    </ul>
  )
};

ChatSession.propTypes = {
  messages: Proptypes.arrayOf(Proptypes.object).isRequired,
};

export default ChatSession;
