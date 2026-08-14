// resources/assets/js/components/chat/messaging.js
import React, { Component } from 'react';
import { connect } from 'react-redux';

import RoomList from './roomlist';
import ChatSession from './chatsession';
import RoomUsers from './roomusers';

import { handleInput, connectToChatkit, connectToRoom, sendMessage, sendDM } from '../../helpers/chat';

class Messaging extends Component {
  constructor() {
    super();
    this.state = {
      isLoading: false,
      currentUser: null,
      currentRoom: null,
      rooms: [],
      roomUsers: [],
      roomName: null,
      messages: [],
      newMessage: ''
    };

    // Bind functions
    this.handleInput = handleInput.bind(this);
    this.connectToChatkit = connectToChatkit.bind(this);
    this.connectToRoom = connectToRoom.bind(this);
    this.sendMessage = sendMessage.bind(this);
    this.sendDM = sendDM.bind(this);
  }




  componentDidMount() {
    // Call connectToChatkit
    this.connectToChatkit();
  }

  render() {
    const {
      rooms,
      currentRoom,
      currentUser,
      messages,
      newMessage,
      roomUsers,
      roomName,
    } = this.state;
      if (screen.width > 640) {
        return (
            <div className="App">
                <div className="mobile-12 tablet-3 large-3 xlarge-3 columns no-padding sidebar-chat">
                    <a href="">
                        <div className="setup-chat">
                            <span className="mdi mdi-settings"></span>
                            <small className="setup-text-chat">&nbsp;Configuración</small>
                        </div>
                    </a>
                  <aside className="sidebar left-sidebar">
                    {  currentUser ? (
                      <div className="user-profile">
                        <span className="username">{currentUser.name}</span>
                        <span className="user-id">{`@${currentUser.id}`}</span>
                      </div>
                    ) : null  }
                      {currentRoom ? (
                          <RoomUsers
                              currentUser={currentUser}
                              sendDM={this.sendDM}
                              roomUsers={roomUsers}
                          />
                      ) : null}
                  </aside>
                </div>
                <div className="mobile-12 tablet-6 large-6 xlarge-6 columns no-padding content-chat">
                  <section className="chat-screen">
                    <header className="chat-header">
                      {currentRoom ? <h3>{roomName} &nbsp; </h3> : null}
                    </header>
                      {currentUser ? (
                        <ChatSession messages={messages} currentUser={currentUser.id} />
                      ) : null }
                    <footer className="chat-footer">
                      <form onSubmit={this.sendMessage} className="message-form">
                      <div>
                          <input type="text"
                                 placeholder="Escribe un mensaje..."
                                 value={newMessage}
                                 name="newMessage"
                                 className="message-input"
                                 onChange={this.handleInput}
                          />
                          <button type="submit" className="button-send">
                              <span className="mdi mdi-send sky-blue">
                              </span>
                          </button>
                      </div>
                      </form>
                    </footer>
                  </section>
                </div>
                <div className="mobile-12 tablet-3 large-3 xlarge-3 columns sidebar-2-chat">
                    <aside className="sidebar right-sidebar">
                      {currentRoom ? (
                          <RoomList
                              rooms={rooms}
                              currentRoom={currentRoom}
                              connectToRoom={this.connectToRoom}
                              currentUser={currentUser}
                          />
                      ) : null}
                    </aside>
                </div>
            </div>
        );
      } else {
        return(
            <div className="mobile-12 App">
                <div className="off-canvas-wrap" data-offcanvas>
                    <div className="inner-wrap">
                        <nav className="tab-bar sky-blue-bg">
                            <section className="left-small">
                                <a className="left-off-canvas-toggle menu-icon" href="#"><span></span></a>
                            </section>

                            <section className="middle tab-bar-section">
                                <div>
                                    {currentRoom ? <h3>{roomName} &nbsp; </h3> : null}
                                </div>
                            </section>

                            <section className="right-small">
                                <a className="right-off-canvas-toggle menu-icon" href="#"><span></span></a>
                            </section>
                        </nav>

                        <aside className="left-off-canvas-menu">
                            <div className="mobile-12 tablet-3 large-3 xlarge-3 columns no-padding sidebar-chat">
                                <a href="">
                                    <div className="setup-chat">
                                        <span className="mdi mdi-settings"></span>
                                        <small className="setup-text-chat">&nbsp;Configuración</small>
                                    </div>
                                </a>
                                <aside className="sidebar left-sidebar">
                                    { /* currentUser ? (
                                          <div className="user-profile">
                                            <span className="username">{currentUser.name}</span>
                                            <span className="user-id">{`@${currentUser.id}`}</span>
                                          </div>
                                        ) : null  */ }
                                    {currentRoom ? (
                                        <RoomUsers
                                            currentUser={currentUser}
                                            sendDM={this.sendDM}
                                            roomUsers={roomUsers}
                                        />
                                    ) : null}
                                </aside>
                            </div>
                        </aside>
                        <aside className="right-off-canvas-menu">
                            <div className="mobile-12 tablet-3 large-3 xlarge-3 columns sidebar-2-chat">
                                <aside className="sidebar right-sidebar">
                                    {currentRoom ? (
                                        <RoomList
                                            rooms={rooms}
                                            currentRoom={currentRoom}
                                            connectToRoom={this.connectToRoom}
                                            currentUser={currentUser}
                                        />
                                    ) : null}
                                </aside>
                            </div>
                        </aside>
                        <section className="main-section">
                            <div className="mobile-12 tablet-6 large-6 xlarge-6 columns no-padding content-chat">
                                <section className="chat-screen">
                                    {currentUser ? (
                                        <ChatSession messages={messages} currentUser={currentUser.id} />
                                    ) : null }
                                    <footer className="chat-footer">
                                        <form onSubmit={this.sendMessage} className="message-form">
                                            <div>
                                                <input type="text"
                                                       placeholder="Escribe un mensaje..."
                                                       value={newMessage}
                                                       name="newMessage"
                                                       className="message-input"
                                                       onChange={this.handleInput}
                                                />
                                                <button type="submit">
                              <span className="mdi mdi-send sky-blue">
                              </span>
                                                </button>
                                            </div>
                                        </form>
                                    </footer>
                                </section>
                            </div>
                        </section>
                        <a className="exit-off-canvas" style={{boxShadow: 'none'}}></a>
                    </div>
                </div>
            </div>
        );
      }
  }
}
const mapStateToProps = state => ({
  user: state.session.user
});

export default connect(mapStateToProps)(Messaging)
