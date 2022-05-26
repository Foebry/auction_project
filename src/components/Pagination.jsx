import React from "react";

const Pagination = ({ previousPage, total, nextPage, start, end }) => {
    return (
        <div className="pagination">
            <div className="pagination__navigation">
                <button
                    className="pagination__navigation__button pagination__navigation__button--prev"
                    disabled={!previousPage}
                >
                    PreviousPage
                </button>
            </div>
            <div className="pagination__info">
                Auctions {start}-{end} of {total} total
            </div>
            <div className="pagination__navigation">
                <button
                    className="pagination__navigation__button pagination__navigation__button--next"
                    disabled={!nextPage}
                >
                    NextPage
                </button>
            </div>
        </div>
    );
};

export default Pagination;
