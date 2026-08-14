// resources/assets/config/index.js
import config from './config.json';

for (var k in config) {
    process.env[k] = config[k]
}
