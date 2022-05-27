import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const auctionAPI = createApi({
    reducerPath: "auctionState",
    baseQuery: fetchBaseQuery({
        baseUrl: import.meta.env.VITE_API,
        credentials: "include",
    }),
    endpoints: (builder) => ({
        getAuctions: builder.query({
            query: ({ categories, page }) => {
                console.log("categories in query", categories);
                console.log("page in query", page);
                const query =
                    categories !== "" || page ? "/auctions?" : "/auctions";

                let params = [];

                if (categories) params = [...params, `cat_id=${categories}`];
                if (page) params = [...params, `page=${page}`];

                params = params.join("&");

                return `${query}${params}`;
            },
            providesTags: ["allAuctions"],
        }),
        getAuctionById: builder.query({
            query: (id) => `/auction/${id}`,
        }),
        getAuctionBiddingsById: builder.query({
            query: (id) => `/auction/${id}/biddings`,
        }),
        postAuction: builder.mutation({
            query: ({ auc_art_id, auc_expiration, csrf }) => ({
                url: `/auctions`,
                method: "POST",
                body: {
                    auc_art_id,
                    auc_expiration,
                    csrf,
                },
            }),
            invalidatesTags: ["allAuctions"],
        }),
    }),
});

export default auctionAPI;
export const {
    useGetAuctionsQuery,
    useGetAuctionByIdQuery,
    useGetAuctionBiddingsByIdQuery,
    usePostAuctionMutation,
} = auctionAPI;
