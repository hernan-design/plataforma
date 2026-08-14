// resources/assets/js/components/decorators/filterData.js
import { decorators } from '@orange-marmalade/paginate-this';
import select from './selectors';

export default function filterData(Component) {
    return decorators.decorate(Component, props => select(props.paginator).filterData())
}
