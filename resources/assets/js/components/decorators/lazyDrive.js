// resources/assets/js/components/decorators/lazyDrive.js
import { decorators } from '@orange-marmalade/paginate-this';
import select from './selectors';

export default function lazyDrive(Component) {
    return decorators.decorate(Component, props => select(props.paginator).lazyDrive())
}
