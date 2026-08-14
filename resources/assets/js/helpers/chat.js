// resources/assets/js/helpers/methods.js
import Chatkit from '@pusher/chatkit-client';


const instanceLocator = "v1:us1:f9176672-7457-4fa1-a155-0771a0343f2b";
const url = "https://us1.pusherplatform.io/services/chatkit_token_provider/v1/f9176672-7457-4fa1-a155-0771a0343f2b/token";
const generalRoom = "8951f007-01b9-4991-a80d-8f929e8ec029";
const key = "2bdfe82f-38c7-42cb-878c-69c985434cfa:TUudOpF2yuw16mmmLm9bYW3b/+gm3IyyWeKLMlUiN+Q=";

function handleInput(event) {
  const { value, name } = event.target;

  this.setState({
    [name]: value,
  });
}

function validUser(user) {
  console.log("validUSer", user);
  // const chatkit = new Chatkit.default({
  //   instanceLocator: instanceLocator,
  //   key: key
  // })
  

//  // console.log('chatkit', chatkit);

//   //  chatkit.getUser({
//   //   id: `${user.codigoUsuario}`,
//   // })
//   // .then(user => console.log('got a user', user))
//   // .catch(err => console.error(err)) 
 }

function connectToChatkit() {
  const { user } = this.props;
  console.log('connectToChatkit', user);

  const userId = `${user.codigoUsuario}`;
  const tokenProvider = new Chatkit.TokenProvider({ url });
  const chatManager = new Chatkit.ChatManager({
    instanceLocator,
    userId,
    tokenProvider,
  });

  return chatManager
    .connect({
      onAddedToRoom: room => {
        const { rooms } = this.state;
        this.setState({
          rooms: [...rooms, room],
        });
      },
    })
    .then(currentUser => {
      this.setState(
        {
          currentUser,
          showLogin: false,
          rooms: currentUser.rooms,
        },
        () => connectToRoom.call(this)
      );
    });
}

function connectToRoom(id = generalRoom) {
  console.log('connectToRoom', id);
  const { currentUser } = this.state;

  this.setState({
    messages: [],
  });

  return currentUser
    .subscribeToRoom({
      roomId: `${id}`,
      messageLimit: 100,
      hooks: {
        onMessage: message => {
          this.setState({
            messages: [...this.state.messages, message],
          });
        },
        onPresenceChanged: () => {
          const { currentRoom } = this.state;
          this.setState({
            roomUsers: currentRoom.users.sort(a => {
              if (a.presence.state === 'online') return -1;

              return 1;
            }),
          });
        },
      },
    })
    .then(currentRoom => {
      const roomName =
        currentRoom.customData && currentRoom.customData.isDirectMessage
          ? currentRoom.customData.userIds.filter(
              id => id !== currentUser.id
            )[0]
          : currentRoom.name;

      this.setState({
        currentRoom,
        roomUsers: currentRoom.users,
        rooms: currentUser.rooms,
        roomName,
      });
    })
    .catch(console.error);
}

function sendMessage(event) {
  event.preventDefault();
  const { newMessage, currentUser, currentRoom } = this.state;

  if (newMessage.trim() === '') return;

  currentUser.sendMessage({
    text: newMessage,
    roomId: `${currentRoom.id}`,
  });

  this.setState({
    newMessage: '',
  });
}

function createPrivateRoom(id) {
  const { currentUser, rooms } = this.state;
  const roomName = `${currentUser.id}_${id}`;

  const isPrivateChatCreated = rooms.filter(room => {
    if (room.customData && room.customData.isDirectMessage) {
      const arr = [currentUser.id, id];
      const { userIds } = room.customData;

      if (arr.sort().join('') === userIds.sort().join('')) {
        return {
          room,
        };
      }
    }

    return false;
  });

  if (isPrivateChatCreated.length > 0) {
    return Promise.resolve(isPrivateChatCreated[0]);
  }

  return currentUser.createRoom({
    name: `${roomName}`,
    private: true,
    addUserIds: [`${id}`],
    customData: {
      isDirectMessage: true,
      userIds: [currentUser.id, id],
    },
  });
}

function sendDM(id) {
  createPrivateRoom.call(this, id).then(room => {
    connectToRoom.call(this, room.id);
  });
}

export { handleInput, connectToChatkit, connectToRoom, sendMessage, sendDM }