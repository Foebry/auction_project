import React from "react";
import {
    MdCardTravel,
    MdRestaurant,
    MdOutlineSpa,
    MdOutlineCardGiftcard,
} from "react-icons/md";

const Categories = () => {
    return (
        <div className="categories container__medium">
            <div className="categories__buttons">
                <button className="categories__buttons__btn">All</button>
                <button className="categories__buttons__btn">
                    <MdCardTravel className="categories__buttons__btn__icon" />
                    Reizen
                </button>
                <button className="categories__buttons__btn">
                    <MdRestaurant className="categories__buttons__btn__icon" />
                    Restaurant
                </button>
                <button className="categories__buttons__btn">
                    <MdOutlineSpa className="categories__buttons__btn__icon" />
                    Wellness
                </button>
                <button className="categories__buttons__btn">
                    <MdOutlineCardGiftcard className="categories__buttons__btn__icon" />
                    Artikelen
                </button>
            </div>
        </div>
    );
};

export default Categories;
