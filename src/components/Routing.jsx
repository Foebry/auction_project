import { Routes, Route } from 'react-router-dom';
import { Routes as views } from '../types/RouteTypes';
import Index from '../views/Index';

const Routing = () => {
  return (
    <Routes>
      <Route path={views.INDEX} element={<Index />} />
    </Routes>
  );
};

export default Routing;
