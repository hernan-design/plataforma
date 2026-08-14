// resources/assets/js/components/decorators/tabulateByState.js
import { decorators } from '@orange-marmalade/paginate-this';
import select from './selectors';
import controlStateFilter from './controlStateFilter';

export default function tabulateByState(WrapperList) {
    return decorators.decorate( controlStateFilter(WrapperList), props => select(props.paginator).tabulateByState() )
}
